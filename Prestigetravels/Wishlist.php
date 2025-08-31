<?php 
ob_start();
include("header.php");
$Rut = $_SESSION['Rut'];
$sentencia=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_usuario=$Rut");
$sentencia->execute();
$lista_hoteles=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$rut = $_SESSION['Rut'];

if(isset($_GET['favIDh'])){
    $ID = $_GET['favIDh'];
    $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',1,0,'$ID',NULL)");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}

if(isset($_GET['delIDh'])){
    $ID = $_GET['delIDh'];
    $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_hotel = $ID");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}

if(isset($_GET['addIDh'])){
    $ID = $_GET['addIDh'];
    $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Noches_hotel`) VALUES (NULL,'$rut',1,0,'$ID',NULL,1)");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}

if(isset($_GET['favIDp'])){
    $ID = $_GET['favIDp'];
    $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',0,1,NULL,'$ID')");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}

if(isset($_GET['delIDp'])){
    $ID = $_GET['delIDp'];
    $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_paquete = $ID");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}

if(isset($_GET['addIDp'])){
    $ID = $_GET['addIDp'];
    $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Personas_paq`) VALUES (NULL,'$rut',0,1,NULL,'$ID',1)");
    if($sentencia->execute() === true){
        header('Location: Wishlist.php');
    }
}?>

<body>
    <?php foreach($lista_hoteles as $registro) {
        if($registro['Tipo_hotel'] === 1){
            $Id = $registro['Id_hotel'];
            $sentencia = $conexion->prepare("SELECT * FROM `hotel` WHERE Id_Hotel=$Id");
            $sentencia->execute();
            $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $nom = $lista[0]['Nombre_Hotel'];

            $img = "Recursos/$nom $Id.jpg";
            
            if($lista[0]['Piscina'] === 1){
                $pis = "Si";
            }
            else{
                $pis = "No";
            }
            if($lista[0]['Estacionamiento'] === 1){
                $est = "Si";
            }
            else{
                $est = "No";
            }
            if($lista[0]['Lavanderia'] === 1){
                $lav = "Si";
            }
            else{
                $lav = "No";
            }
            if($lista[0]['Pet_Friendly'] === 1){
                $pet = "Si";
            }
            else{
                $pet = "No";
            }
            if($lista[0]['Desayuno'] === 1){
                $des = "Si";
            }
            else{
                $des = "No";
            }

            $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_hotel = $Id");
            $consultaw->execute();
            $listaw = $consultaw->fetchAll(PDO::FETCH_ASSOC);
            $wishlist=true;
            if(count($listaw) === 0){
                $wishlist=false;
            }?>
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
                        <h2 class="card-title"><?php echo $lista[0]['Nombre_Hotel']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                        <p class="card-text">Precio por noche: $<?php echo $lista[0]['Precio_Noche']?></p>
                        <p class="card-text">Ubicacion: <?php echo $lista[0]['Ciudad']?></p>
                        <p class="card-text">Habitaciones totales: <?php echo $lista[0]['Habitaciones_Totales']?></p>
                        <p class="card-text">Habitaciones disponibles: <?php echo $lista[0]['Habitaciones_Disponibles']?></p>
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
                        <img src = '<?php echo $lista[0]['Url_img']?>' width="70%" >
                    </td>
                    <td class = "card-body"style ="width:20%">
                    <?php 
                    $disponibles = $lista[0]["Habitaciones_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                        <?php 
                        $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_hotel = $Id");
                        $sentencia->execute();
                        $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                        if(count($lista_carrrito) < $disponibles){ 
                        ?>
                        <form method="post">
                            <a name="" id="" class="btn btn-success btn-lg" href="Wishlist.php?addIDh=<?php echo $Id; ?>" role="button">Añadir al Carrito</a>
                        </form>
                        <?php }?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Wishlist.php?favIDh=<?php echo $Id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Wishlist.php?delIDh=<?php echo $Id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php }?>
                        </br>
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $Id; ?>" role="button">Ir al Sitio</a>
                    </td>
                </table>
            </div>
            </div>
    <?php 
        }
        
        if($registro['Tipo_paquete'] === 1){
            $Id = $registro['Id_paquete'];
            $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE ID_Paquete=$Id");
            $sentencia->execute();
            $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            $nom = $lista[0]['Nombre_paquete'];
            $id = $lista[0]['ID_Paquete'];
            $img = "Recursos/$nom $id.jpg";
            $idh=$lista[0]['Id_Hospedaje'];
            $idc=$lista[0]['Id_Ciudad'];
            
            $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
            $consultah->execute();
            $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);

            $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
            $consultac->execute();
            $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
            
            $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_paquete = $Id");
            $consultaw->execute();
            $listaw = $consultaw->fetchAll(PDO::FETCH_ASSOC);
            $wishlist=true;
            if(count($listaw) === 0){
                $wishlist=false;
            }
            ?>
            <!-- Cálculo de estrellas -->
            <?php
            $sentencia = $conexion->prepare("SELECT Id_Compra FROM compra WHERE ID_Paquete = '$id'");
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
            $sentencia = $conexion->prepare("UPDATE paquete SET Estrellas = '$estrellas' WHERE ID_Paquete = '$id'");
            $sentencia->execute();

            $sentencia = $conexion->prepare("SELECT Estrellas FROM paquete WHERE ID_Paquete = '$id'");
            $sentencia->execute();
            $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $estrellas = $lista[0]['Estrellas'];
            ?>
            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:20%">
                        <h2 class="card-title"><?php echo $lista[0]['Nombre_paquete']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                        <p class="card-text">Precio por persona: $<?php echo $lista[0]['Precio_Persona']?></p>
                        <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $lista[0]['Aerolinea_Ida']?></i></p>
                        <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $lista[0]['Aerolinea_Vuelta']?></i></p>
                        <p class="card-text">Fecha salida: <?php echo $lista[0]['Fecha_Salida']?></p>
                        <p class="card-text">Fecha llegada: <?php echo $lista[0]['Fecha_Vuelta']?></p>
                        <p class="card-text">Paquetes totales: <?php echo $lista[0]['Paquetes_Totales']?></p>
                        <p class="card-text">Paquetes disponibles: <?php echo $lista[0]['Paquetes_Disponibles']?></p>
                    </td>
                    <td class = "card-body" style ="width:20%">
                        <p><i class="fa fa-users"> Cantidad de personas max.: <?php echo $lista[0]['Personas_Maximo']?></i></p>
                        <p><i class="fa fa-h-square"> Hoteles:</i>
                            <div class="row">
                                <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H1']?></p>
                                <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H2']?></p>
                                <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H3']?></p>
                            </div>
                        </p>
                        <p><i class="fa fa-map"> Ciudades: </i>
                            <div class="row">
                                <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C1']?></p>
                                <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C2']?></p>
                                <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C3']?></p>
                            </div>
                        </p>
                    </tod>
                    <td class = "card-body"style ="width:40% heigh:100%">
                        <!-- Mostrar imagen -->
                        <img src = '<?php echo $lista[0]['Url_img']?>' width="70%" >
                    </td>
                    <td class = "card-body"style ="width:20%">
                    <?php 
                    $disponibles = $lista[0]["Paquetes_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                        <?php 
                        $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_paquete = $id");
                        $sentencia->execute();
                        $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                        if(count($lista_carrrito) < $disponibles){ 
                        ?>
                        <form method="post">
                            <a name="" id="" class="btn btn-success btn-lg" href="Wishlist.php?addIDp=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                        </form>
                        <?php }?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Wishlist.php?favIDp=<?php echo $id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Wishlist.php?delIDp=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php }?>
                        </br>
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $id; ?>" role="button">Ir al Sitio</a>
                    </td>
                </table>
            </div>
            </div>
        <?php }
    } ?>
</body>