<?php
ob_start();
include("header.php");
$sentencia=$conexion->prepare("SELECT * FROM `hotel`");
$sentencia->execute();
$lista_hoteles=$sentencia->fetchAll(PDO::FETCH_ASSOC);
if(isset($_SESSION['logueado'])){
$rut = $_SESSION['Rut'];
}
if(isset($_GET['favID'])){
    $ID = $_GET['favID'];
    $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',1,0,'$ID',NULL)");
    if($sentencia->execute() === true){
        header('Location: Hoteles.php');
    }
}

if(isset($_GET['delID'])){
    $ID = $_GET['delID'];
    $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_hotel = $ID");
    if($sentencia->execute() === true){
        header('Location: Hoteles.php');
    }
}

if(isset($_GET['addID'])){
    $ID = $_GET['addID'];
    $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Noches_hotel`) VALUES (NULL,'$rut',1,0,'$ID',NULL,1)");
    if($sentencia->execute() === true){
        header('Location: Hoteles.php');
    }
}?>

<body>
    <?php foreach($lista_hoteles as $registro) {
        $nom = $registro['Nombre_Hotel'];
        $id = $registro['Id_Hotel'];
        $img = $registro['Url_img'];

        if($registro['Piscina'] === 1){
            $pis = "Si";
        }
        else{
            $pis = "No";
        } 
        if($registro['Estacionamiento'] === 1){
            $est = "Si";
        }
        else{
            $est = "No";
        }
        if($registro['Lavanderia'] === 1){
            $lav = "Si";
        }
        else{
            $lav = "No";
        }
        if($registro['Pet_Friendly'] === 1){
            $pet = "Si";
        }
        else{
            $pet = "No";
        }
        if($registro['Desayuno'] === 1){
            $des = "Si";
        }
        else{
            $des = "No";
        }

        $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_hotel = $id");
        $consultaw->execute();
        $listaw = $consultaw->fetchAll(PDO::FETCH_ASSOC);
        $wishlist=true;
        if(count($listaw) === 0){
            $wishlist=false;
        }
        ?>
        <!-- Cálculo de estrellas -->
        <?php
        $sentencia = $conexion->prepare("SELECT Id_Compra FROM compra WHERE Id_hotel = '$id'");
        $sentencia->execute();
        $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $stars = 0;
        $contador = count($lista);
        if($contador === 0){
            $contador =1;
        }
        foreach($lista as $registro1){
            $ID_compra = $registro1['Id_Compra'];
            $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
            $sentencia->execute();
            $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $cant = count($lista);
            if($cant > 0){
                $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
            }else{
                $prom = 0;
            }
            $stars = $stars + $prom;
        }

        $estrellas = $stars / $contador;
        $sentencia = $conexion->prepare("UPDATE hotel SET Estrellas = '$estrellas' WHERE Id_Hotel = '$id'");
        $sentencia->execute();

        $sentencia = $conexion->prepare("SELECT Estrellas FROM hotel WHERE Id_Hotel = '$id'");
        $sentencia->execute();
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $estrellas = $lista[0]['Estrellas'];
        ?>
        <div class="card mb-3">
        <div class="card-body">
            <table>
                <td class = "card-body" style ="width:20%">
                    <h2 class="card-title"><?php echo $registro['Nombre_Hotel']?></h2>
                    <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                    <p class="card-text">Precio por noche: $<?php echo $registro['Precio_Noche']?></p>
                    <p class="card-text">Ubicacion: <?php echo $registro['Ciudad']?></p>
                    <p class="card-text">Habitaciones totales: <?php echo $registro['Habitaciones_Totales']?></p>
                    <p class="card-text">Habitaciones disponibles: <?php echo $registro['Habitaciones_Disponibles']?></p>
                </td>
                <td class = "card-body" style ="width:20%">
                    <!-- Mostrar iconos-->
                    <p><i class="fa fa-car"> Estacionamiento: <?php echo $est?></i></p>
                    <p><i class="fa fa-life-ring"> Piscina: <?php echo $pis?></i></p>
                    <p><i class="fa fa-tint"> Lavanderia: <?php echo $lav?></i></p>
                    <p><i class="fa fa-cutlery"> Desayuno: <?php echo $des?></i></p>
                    <p><i class="fa fa-paw"> Petfriendly: <?php echo $pet?></i></p>
                </tod>
                <td class = "card-body"style ="width:40% heigh:100%">
                    <!-- Mostrar imagen -->
                    <img src = '<?php echo $registro['Url_img']?>' width="70%" >
                </td>
                <td class = "card-body"style ="width:20%">
                <?php 
                    $disponibles = $registro["Habitaciones_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                    <?php 
                    $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_hotel = $id");
                    $sentencia->execute();
                    $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                    if(count($lista_carrrito) < $disponibles and isset($_SESSION['logueado'])){ 
                    ?>
                    <form method="post">
                        <a name="" id="" class="btn btn-success btn-lg" href="Hoteles.php?addID=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                    </form>
                    <?php } ?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if(isset($_SESSION['logueado'])){
                        if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Hoteles.php?favID=<?php echo $id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Hoteles.php?delID=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php 
                        }
                    }?>
                    </br>
                    <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $id; ?>" role="button">Ir al Sitio</a>
                </td>
            </table>
        </div>
        </div>
    <?php } ?>
</body>
