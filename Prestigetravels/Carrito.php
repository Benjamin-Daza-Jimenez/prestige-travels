<?php
ob_start();
include("header.php");
$rut = $_SESSION['Rut'];
$sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_usuario = '$rut'");
$sentencia->execute();
$lista_carrito = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$total = 0;

if(isset($_GET['masID'])){
    $ID = $_GET['masID'];
    $sentencia = $conexion->prepare("SELECT Personas_paq FROM `carrito` WHERE Id_carrito = $ID");
    if($sentencia->execute() === true){
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $nuevo = $lista[0]['Personas_paq'] + 1;
        $sentencia = $conexion->prepare("UPDATE `carrito` SET Personas_paq = $nuevo WHERE Id_carrito = $ID;");
        if($sentencia->execute() === true){
            header('Location: Carrito.php');
        }
    }
}

if(isset($_GET['menosID'])){
    $ID = $_GET['menosID'];
    $sentencia = $conexion->prepare("SELECT Personas_paq FROM `carrito` WHERE Id_carrito = $ID");
    if($sentencia->execute() === true){
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $nuevo = $lista[0]['Personas_paq'] - 1;
        $sentencia = $conexion->prepare("UPDATE `carrito` SET Personas_paq = $nuevo WHERE Id_carrito = $ID;");
        if($sentencia->execute() === true){
            header('Location: Carrito.php');
        }
    }
}

if(isset($_GET['mas_ID'])){
    $ID = $_GET['mas_ID'];
    $sentencia = $conexion->prepare("SELECT Noches_hotel FROM `carrito` WHERE Id_carrito = $ID");
    if($sentencia->execute() === true){
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $nuevo = $lista[0]['Noches_hotel'] + 1;
        $sentencia = $conexion->prepare("UPDATE `carrito` SET Noches_hotel = $nuevo WHERE Id_carrito = $ID;");
        if($sentencia->execute() === true){
            header('Location: Carrito.php');
        }
    }
}

if(isset($_GET['menos_ID'])){
    $ID = $_GET['menos_ID'];
    $sentencia = $conexion->prepare("SELECT Noches_hotel FROM `carrito` WHERE Id_carrito = $ID");
    if($sentencia->execute() === true){
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $nuevo = $lista[0]['Noches_hotel'] - 1;
        $sentencia = $conexion->prepare("UPDATE `carrito` SET Noches_hotel = $nuevo WHERE Id_carrito = $ID;");
        if($sentencia->execute() === true){
            header('Location: Carrito.php');
        }
    }
}

if(isset($_GET['delID'])){
    $ID = $_GET['delID'];
    $sentencia = $conexion->prepare("DELETE FROM `carrito` WHERE Id_carrito = $ID");
    if($sentencia->execute() === true){
        header('Location: Carrito.php');
    }
}

//Actualizar todo
if(isset($_GET['buyID'])){
    $ID = $_GET['buyID'];
    $Descuento = $_SESSION['Descuento'];
    $_SESSION['Descuento'] = 0;
    $sentencia = $conexion->prepare("UPDATE `usuario` SET Descuento = 0 WHERE Rut = $rut;");
    $sentencia->execute();
    $fecha = date("Y-m-d");

    foreach($lista_carrito as $producto){ //Baja la disponibilidad a cada uno.
        if($producto['Tipo_hotel'] === 1){
            $ID_producto = $producto['Id_carrito'];
            $ID_hotel = $producto['Id_hotel'];
            $noches = $producto['Noches_hotel'];
            $sentencia = $conexion->prepare("UPDATE `hotel` SET Habitaciones_Disponibles = Habitaciones_Disponibles - 1 WHERE Id_Hotel = $ID_hotel;");
            $sentencia->execute();

            $sentencia = $conexion->prepare("INSERT INTO `compra`(`Id_compra`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Personas_paq`,`Fecha_compra`,`Descuento`,`Noches_hotel`) VALUES (NULL,'$rut',1,0,'$ID_hotel',NULL,NULL,'$fecha','$Descuento','$noches')");
            $sentencia->execute();
        }
        if($producto['Tipo_paquete'] === 1){
            $ID_producto = $producto['Id_carrito'];
            $ID_paquete = $producto['Id_paquete'];
            $personas  = $producto['Personas_paq'];
            $sentencia = $conexion->prepare("UPDATE `paquete` SET Paquetes_Disponibles = Paquetes_Disponibles - 1 WHERE Id_Paquete = $ID_paquete;");
            $sentencia->execute();

            $sentencia = $conexion->prepare("INSERT INTO `compra`(`Id_compra`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Personas_paq`,`Fecha_compra`,`Descuento`) VALUES (NULL,'$rut',0,1,NULL,'$ID_paquete','$personas','$fecha','$Descuento')");
            $sentencia->execute();
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM `carrito` WHERE Id_usuario = $ID");
    $sentencia->execute();
    if($sentencia->execute() === true){
        header('Location: Carrito.php');
    }
}
?>

<body>
    <section class="h-100 gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center my-4">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Carrito</h5>
                        </div>
                        <?php 
                            foreach($lista_carrito as $producto){
                                $cant_personas = $producto['Personas_paq'];
                                if($producto['Tipo_hotel'] === 1){
                                    $ID_producto = $producto['Id_carrito']; 
                                    $ID_hotel = $producto['Id_hotel'];
                                    $sentencia = $conexion->prepare("SELECT * FROM `hotel` WHERE Id_Hotel=$ID_hotel");
                                    $sentencia->execute();
                                    $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                                    $nom = $lista[0]['Nombre_Hotel'];
                                    $precio = $lista[0]['Precio_Noche'];
                                    $noches = $producto['Noches_hotel'];
                                    $total = $total + ($precio*$noches);

                                    $img = "Recursos/$nom $ID_hotel.jpg";

                        ?> 
                        <div class="card-body">
                            <!-- Single item -->
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src = '<?php echo $lista[0]['Url_img']?>' width="70%">
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><h4><?php echo $nom ?></strong></h4></p>
                                    <form method="post">
                                        <a role="button" class="btn btn-primary" href="Carrito.php?delID=<?php echo $ID_producto; ?>">Sacar del Carrito</a>
                                    </form>
                                    </br>
                                    <form method="POST" action="Carrito.php">
                                        <div class="row">
                                            <div class= "col-md-6">
                                                <p>Cantidad de noches:</p>
                                            </div>
                                        <div class= "col-md-4">
                                            <!-- mostrar el boton de "-" -->
                                            <?php if($noches > 1){?>
                                            <a name="" id="" class="btn btn-danger btn-sm" href="Carrito.php?menos_ID=<?php echo $ID_producto; ?>" role="button">-</a>
                                            <?php }?>
                                            <!-- mostrar cantidad de personas -->
                                            <?php echo $noches; ?>
                                            <!-- mostrar el boton de "+" -->
                                            <a name="" id="" class="btn btn-success btn-sm" href="Carrito.php?mas_ID=<?php echo $ID_producto; ?>" role="button">+</a>
                                        </div>
                                    </form>
                                </div>
                                    <!-- Data -->
                                </div>
                               

                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Price -->
                                    <p class="text-start text-md-center">
                                        <h4><strong><?php echo "$" . ($precio * $noches)?></strong></h4>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>
                            <!-- Single item -->
                            <hr class="my-4" />
                        </div>
                    <?php }

                    if($producto['Tipo_paquete'] === 1){
                        $ID_producto = $producto['Id_carrito']; 
                        $ID_paquete = $producto['Id_paquete'];
                        $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE ID_Paquete=$ID_paquete");
                        $sentencia->execute();
                        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                        $nom = $lista[0]['Nombre_paquete'];
                        $precio = $lista[0]['Precio_Persona'];
                        $maxp = $lista[0]['Personas_Maximo'];
                        $total = $total + ($precio*$producto['Personas_paq']);
                        $img = "Recursos/$nom $ID_paquete.jpg";?>

                        <div class="card-body">
                            <!-- Single item -->
                            <div class="row">
                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                        <img src = '<?php echo $lista[0]['Url_img']?>' width="70%">
                                    </div>
                                    <!-- Image -->
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                    <!-- Data -->
                                    <p><strong><h4><?php echo $nom ?></strong></h4></p>
                                    <form method="post">
                                        <a role="button" class="btn btn-primary" href="Carrito.php?delID=<?php echo $ID_producto; ?>">Sacar del Carrito</a>
                                    </form>
                                    </br>
                                    <form method="POST" action="Carrito.php">
                                        <div class="row">
                                            <div class= "col-md-6">
                                                <p>Cantidad de personas:</p>
                                            </div>
                                            <div class= "col-md-4">
                                                <!-- mostrar el boton de "-" -->
                                                <?php if($cant_personas > 1){?>
                                                    <a name="" id="" class="btn btn-danger btn-sm" href="Carrito.php?menosID=<?php echo $ID_producto; ?>" role="button">-</a>
                                                <?php }?>
                                                <!-- mostrar cantidad de personas -->
                                                <?php echo $cant_personas?>
                                                <!-- mostrar el boton de "+" -->
                                                <?php if($cant_personas < $maxp){?>
                                                    <a name="" id="" class="btn btn-success btn-sm" href="Carrito.php?masID=<?php echo $ID_producto; ?>" role="button">+</a>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Data -->
                                </div>
                                <!-- Actualizar -->
                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                    <!-- Price -->
                                    <p class="text-start text-md-center">
                                    <h4><strong><?php echo "$" . $precio * $producto['Personas_paq'];?></strong></h4>
                                    </p>
                                    <!-- Price -->
                                </div>
                            </div>
                            <!-- Single item -->
                            <hr class="my-4" />
                        </div>            
            <?php           
                    }
                }
            ?>      </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header py-3">
                            <h5 class="mb-0">Resumen de Compra</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                    Productos
                                    <span><?php echo "$" . $total ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    Descuento
                                    <?php if($_SESSION['Descuento'] === 1){
                                        $descuento=0.9;?>
                                    <span>10%</span>
                                    <?php }else{
                                        $descuento=1;?>
                                    <span>No aplica</span>
                                    <?php }?>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Monto Total</strong>
                                    </div>
                                    <span><strong><?php echo "$" . ($total*$descuento)?></strong></span>
                                </li>
                            </ul>
                            <div class="row">
                                <form method="post">
                                    <div class = "col-md-4">
                                        <a role="button" class="btn btn-primary btn-lg btn-block" href="Carrito.php?buyID=<?php echo $rut; ?>">Pagar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>