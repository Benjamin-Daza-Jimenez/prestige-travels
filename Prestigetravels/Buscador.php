<?php 
ob_start();
include('header.php');

if(isset($_POST['Palabra'])){
    $palabra = $_POST['Palabra'];
    $rut = $_SESSION['Rut'];

    if(isset($_GET['favIDh'])){
        $ID = $_GET['favIDh'];
        $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',1,0,'$ID',NULL)");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }
    
    if(isset($_GET['delIDh'])){
        $ID = $_GET['delIDh'];
        $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_hotel = $ID");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }
    
    if(isset($_GET['addIDh'])){
        $ID = $_GET['addIDh'];
        $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Noches_hotel`) VALUES (NULL,'$rut',1,0,'$ID',NULL,1)");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }
    
    if(isset($_GET['favIDp'])){
        $ID = $_GET['favIDp'];
        $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',0,1,NULL,'$ID')");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }
    
    if(isset($_GET['delIDp'])){
        $ID = $_GET['delIDp'];
        $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_paquete = $ID");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }
    
    if(isset($_GET['addIDp'])){
        $ID = $_GET['addIDp'];
        $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Personas_paq`) VALUES (NULL,'$rut',0,1,NULL,'$ID',1)");
        if($sentencia->execute() === true){
            header('Location: Buscador.php');
        }
    }

    //nombre hotel
    $sentencia = $conexion->prepare("SELECT * FROM `hotel` WHERE Nombre_Hotel = '$palabra'");
    $sentencia->execute();
    $lista_hoteles = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
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
            foreach($lista as $registro1){
                $ID_compra = $registro1['Id_Compra'];
                $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $cant = count($lista);
                if($cant > 0){
                    $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                    $sentencia = $conexion->prepare("UPDATE hotel SET Estrellas = '$prom' WHERE Id_Hotel = '$id'");
                    $sentencia->execute();
                }
                $sentencia = $conexion->prepare("SELECT Estrellas FROM hotel WHERE Id_Hotel = '$id'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $estrellas = $lista[0]['Estrellas'];
            }
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
                        if(count($lista_carrrito) < $disponibles){ 
                        ?>
                        <form method="post">
                            <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDh=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                        </form>
                        <?php } ?>
                        </div>
                        </br>
                        <?php }?>
                        <?php if($wishlist === false){?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDh=<?php echo $id; ?>" role="button">Favorito</a>
                                </form>
                            <div>
                        <?php }else{ ?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDh=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                                </form>
                            <div>
                        <?php }?>
                        </br>
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $id; ?>" role="button">Ir al Sitio</a>
                    </td>
                </table>
            </div>
            </div>
        <?php } ?>
    </body>
<?php
    //nombre paquete
    $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE Nombre_paquete = '$palabra'");
    $sentencia->execute();
    $lista_paquetes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
    <body>
        <?php foreach($lista_paquetes as $registro) {
            $nom = $registro['Nombre_paquete'];
            $id = $registro['ID_Paquete'];
            $img = $registro['Url_img'];
            $idh=$registro['Id_Hospedaje'];
            $idc=$registro['Id_Ciudad'];
            
            $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
            $consultah->execute();
            $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);
            
            $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
            $consultac->execute();
            $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
            
            $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_paquete = $id");
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
            foreach($lista as $registro1){
                $ID_compra = $registro1['Id_Compra'];
                $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $cant = count($lista);
                if($cant > 0){
                    $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                    $sentencia = $conexion->prepare("UPDATE paquete SET Estrellas = '$prom' WHERE ID_Paquete = '$id'");
                    $sentencia->execute();
                }
                $sentencia = $conexion->prepare("SELECT Estrellas FROM paquete WHERE ID_Paquete = '$id'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $estrellas = $lista[0]['Estrellas'];
            }
            ?>
            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:20%">
                        <h2 class="card-title"><?php echo $registro['Nombre_paquete']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                        <p class="card-text">Precio por persona: $<?php echo $registro['Precio_Persona']?></p>
                        <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $registro['Aerolinea_Ida']?></i></p>
                        <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $registro['Aerolinea_Vuelta']?></i></p>
                        <p class="card-text">Fecha salida: <?php echo $registro['Fecha_Salida']?></p>
                        <p class="card-text">Fecha llegada: <?php echo $registro['Fecha_Vuelta']?></p>
                        <p class="card-text">Paquetes totales: <?php echo $registro['Paquetes_Totales']?></p>
                        <p class="card-text">Paquetes disponibles: <?php echo $registro['Paquetes_Disponibles']?></p>
                    </td>
                    <td class = "card-body" style ="width:20%">
                        <p><i class="fa fa-users"> Cantidad de personas max.: <?php echo $registro['Personas_Maximo']?></i></p>
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
                        <img src = '<?php echo $registro['Url_img']?>' width="70%" >
                    </td>
                    <td class = "card-body"style ="width:20%">
                    <?php 
                    $disponibles = $registro["Paquetes_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                    <?php 
                    $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_paquete = $id");
                    $sentencia->execute();
                    $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                    if(count($lista_carrrito) < $disponibles){ 
                    ?>
                    <form method="post">
                        <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDp=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                    </form>
                    <?php }?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDp=<?php echo $id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDp=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php }?>
                    </br>
                    <p><a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</i></a></p>
                    </td>
                </table>
            </div>
            </div>
        <?php } ?>
    </body>
<?php
    //ciudad hotel
    $sentencia = $conexion->prepare("SELECT * FROM `hotel` WHERE Ciudad = '$palabra'");
    $sentencia->execute();
    $lista_hc = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
    <body>
        <?php foreach($lista_hc as $registro) {
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
            foreach($lista as $registro1){
                $ID_compra = $registro1['Id_Compra'];
                $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $cant = count($lista);
                if($cant > 0){
                    $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                    $sentencia = $conexion->prepare("UPDATE hotel SET Estrellas = '$prom' WHERE Id_Hotel = '$id'");
                    $sentencia->execute();
                }
                $sentencia = $conexion->prepare("SELECT Estrellas FROM hotel WHERE Id_Hotel = '$id'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $estrellas = $lista[0]['Estrellas'];
            }
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
                        if(count($lista_carrrito) < $disponibles){ 
                        ?>
                        <form method="post">
                            <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDh=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                        </form>
                        <?php } ?>
                        </div>
                        </br>
                        <?php }?>
                        <?php if($wishlist === false){?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDh=<?php echo $id; ?>" role="button">Favorito</a>
                                </form>
                            <div>
                        <?php }else{ ?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDh=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                                </form>
                            <div>
                        <?php }?>
                        </br>
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $id; ?>" role="button">Ir al Sitio</a>
                    </td>
                </table>
            </div>
            </div>
        <?php } ?>
    </body>
<?php
    //ciudad paquete
    $sentencia = $conexion->prepare("SELECT * FROM `ciudad` WHERE C1 = '$palabra' or C2 = '$palabra' or C3 = '$palabra'");
    $sentencia->execute();
    $lista_ciudades = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    foreach($lista_ciudades as $ciudades){
        $ID_ciudad = $ciudades['Id_Ciudad'];
        $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE Id_Ciudad = $ID_ciudad");
        $sentencia->execute();
        $lista_pc = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
        <body>
            <?php foreach($lista_pc as $registro) {
                $nom = $registro['Nombre_paquete'];
                $id = $registro['ID_Paquete'];
                $img = $registro['Url_img'];
                $idh=$registro['Id_Hospedaje'];
                $idc=$registro['Id_Ciudad'];
                
                $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
                $consultah->execute();
                $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);
                
                $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
                $consultac->execute();
                $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
                
                $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_paquete = $id");
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
                foreach($lista as $registro1){
                    $ID_compra = $registro1['Id_Compra'];
                    $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                    $sentencia->execute();
                    $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    $cant = count($lista);
                    if($cant > 0){
                        $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                        $sentencia = $conexion->prepare("UPDATE paquete SET Estrellas = '$prom' WHERE ID_Paquete = '$id'");
                        $sentencia->execute();
                    }
                    $sentencia = $conexion->prepare("SELECT Estrellas FROM paquete WHERE ID_Paquete = '$id'");
                    $sentencia->execute();
                    $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                    $estrellas = $lista[0]['Estrellas'];
                }
                ?>
                <div class="card mb-3">
                <div class="card-body">
                    <table>
                        <td class = "card-body" style ="width:20%">
                            <h2 class="card-title"><?php echo $registro['Nombre_paquete']?></h2>
                            <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                            <p class="card-text">Precio por persona: $<?php echo $registro['Precio_Persona']?></p>
                            <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $registro['Aerolinea_Ida']?></i></p>
                            <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $registro['Aerolinea_Vuelta']?></i></p>
                            <p class="card-text">Fecha salida: <?php echo $registro['Fecha_Salida']?></p>
                            <p class="card-text">Fecha llegada: <?php echo $registro['Fecha_Vuelta']?></p>
                            <p class="card-text">Paquetes totales: <?php echo $registro['Paquetes_Totales']?></p>
                            <p class="card-text">Paquetes disponibles: <?php echo $registro['Paquetes_Disponibles']?></p>
                        </td>
                        <td class = "card-body" style ="width:20%">
                            <p><i class="fa fa-users"> Cantidad de personas max.: <?php echo $registro['Personas_Maximo']?></i></p>
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
                            <img src = '<?php echo $registro['Url_img']?>' width="70%" >
                        </td>
                        <td class = "card-body"style ="width:20%">
                        <?php 
                        $disponibles = $registro["Paquetes_Disponibles"];
                        if($disponibles > 0){ ?>
                        <div class="flex">
                        <?php 
                        $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_paquete = $id");
                        $sentencia->execute();
                        $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                        if(count($lista_carrrito) < $disponibles){ 
                        ?>
                        <form method="post">
                            <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDp=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                        </form>
                        <?php }?>
                        </div>
                        </br>
                        <?php }?>
                        <?php if($wishlist === false){?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDp=<?php echo $id; ?>" role="button">Favorito</a>
                                </form>
                            <div>
                        <?php }else{ ?>
                            <div class="flex">
                                <form method="post">
                                    <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDp=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                                </form>
                            <div>
                        <?php }?>
                        </br>
                        <p><a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</i></a></p>
                        </td>
                    </table>
                </div>
                </div>
            <?php } ?>
        </body>
<?php
    }

    //fecha inicio
    $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE Fecha_Salida = '$palabra'");
    $sentencia->execute();
    $lista_salida = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
    <body>
        <?php foreach($lista_salida as $registro) {
            $nom = $registro['Nombre_paquete'];
            $id = $registro['ID_Paquete'];
            $img = $registro['Url_img'];
            $idh=$registro['Id_Hospedaje'];
            $idc=$registro['Id_Ciudad'];
            
            $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
            $consultah->execute();
            $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);
            
            $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
            $consultac->execute();
            $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
            
            $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_paquete = $id");
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
            foreach($lista as $registro1){
                $ID_compra = $registro1['Id_Compra'];
                $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $cant = count($lista);
                if($cant > 0){
                    $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                    $sentencia = $conexion->prepare("UPDATE paquete SET Estrellas = '$prom' WHERE ID_Paquete = '$id'");
                    $sentencia->execute();
                }
                $sentencia = $conexion->prepare("SELECT Estrellas FROM paquete WHERE ID_Paquete = '$id'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $estrellas = $lista[0]['Estrellas'];
            }
            ?>
            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:20%">
                        <h2 class="card-title"><?php echo $registro['Nombre_paquete']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                        <p class="card-text">Precio por persona: $<?php echo $registro['Precio_Persona']?></p>
                        <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $registro['Aerolinea_Ida']?></i></p>
                        <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $registro['Aerolinea_Vuelta']?></i></p>
                        <p class="card-text">Fecha salida: <?php echo $registro['Fecha_Salida']?></p>
                        <p class="card-text">Fecha llegada: <?php echo $registro['Fecha_Vuelta']?></p>
                        <p class="card-text">Paquetes totales: <?php echo $registro['Paquetes_Totales']?></p>
                        <p class="card-text">Paquetes disponibles: <?php echo $registro['Paquetes_Disponibles']?></p>
                    </td>
                    <td class = "card-body" style ="width:20%">
                        <p><i class="fa fa-users"> Cantidad de personas max.: <?php echo $registro['Personas_Maximo']?></i></p>
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
                        <img src = '<?php echo $registro['Url_img']?>' width="70%" >
                    </td>
                    <td class = "card-body"style ="width:20%">
                    <?php 
                    $disponibles = $registro["Paquetes_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                    <?php 
                    $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_paquete = $id");
                    $sentencia->execute();
                    $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                    if(count($lista_carrrito) < $disponibles){ 
                    ?>
                    <form method="post">
                        <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDp=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                    </form>
                    <?php }?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDp=<?php echo $id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDp=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php }?>
                    </br>
                    <p><a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</i></a></p>
                    </td>
                </table>
            </div>
            </div>
        <?php } ?>
    </body>       
<?php
    //fecha fin
    $sentencia = $conexion->prepare("SELECT * FROM `paquete` WHERE Fecha_Vuelta = '$palabra'");
    $sentencia->execute();
    $lista_vuelta = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
    <body>
        <?php foreach($lista_salida as $registro) {
            $nom = $registro['Nombre_paquete'];
            $id = $registro['ID_Paquete'];
            $img = $registro['Url_img'];
            $idh=$registro['Id_Hospedaje'];
            $idc=$registro['Id_Ciudad'];
            
            $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
            $consultah->execute();
            $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);
            
            $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
            $consultac->execute();
            $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
            
            $consultaw=$conexion->prepare("SELECT * FROM `wishlist` WHERE Id_paquete = $id");
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
            foreach($lista as $registro1){
                $ID_compra = $registro1['Id_Compra'];
                $sentencia = $conexion->prepare("SELECT Cal1, Cal2, Cal3, Cal4 FROM comentario WHERE Id_compra = '$ID_compra'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $cant = count($lista);
                if($cant > 0){
                    $prom = (int)($lista[0]['Cal1'] + $lista[0]['Cal2'] + $lista[0]['Cal3'] + $lista[0]['Cal4'])/4;
                    $sentencia = $conexion->prepare("UPDATE paquete SET Estrellas = '$prom' WHERE ID_Paquete = '$id'");
                    $sentencia->execute();
                }
                $sentencia = $conexion->prepare("SELECT Estrellas FROM paquete WHERE ID_Paquete = '$id'");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $estrellas = $lista[0]['Estrellas'];
            }
            ?>
            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:20%">
                        <h2 class="card-title"><?php echo $registro['Nombre_paquete']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $estrellas?> / 5</i></p>
                        <p class="card-text">Precio por persona: $<?php echo $registro['Precio_Persona']?></p>
                        <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $registro['Aerolinea_Ida']?></i></p>
                        <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $registro['Aerolinea_Vuelta']?></i></p>
                        <p class="card-text">Fecha salida: <?php echo $registro['Fecha_Salida']?></p>
                        <p class="card-text">Fecha llegada: <?php echo $registro['Fecha_Vuelta']?></p>
                        <p class="card-text">Paquetes totales: <?php echo $registro['Paquetes_Totales']?></p>
                        <p class="card-text">Paquetes disponibles: <?php echo $registro['Paquetes_Disponibles']?></p>
                    </td>
                    <td class = "card-body" style ="width:20%">
                        <p><i class="fa fa-users"> Cantidad de personas max.: <?php echo $registro['Personas_Maximo']?></i></p>
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
                        <img src = '<?php echo $registro['Url_img']?>' width="70%" >
                    </td>
                    <td class = "card-body"style ="width:20%">
                    <?php 
                    $disponibles = $registro["Paquetes_Disponibles"];
                    if($disponibles > 0){ ?>
                    <div class="flex">
                    <?php 
                    $sentencia = $conexion->prepare("SELECT * FROM `carrito` WHERE Id_paquete = $id");
                    $sentencia->execute();
                    $lista_carrrito=$sentencia->fetchAll(PDO::FETCH_ASSOC);    
                    if(count($lista_carrrito) < $disponibles){ 
                    ?>
                    <form method="post">
                        <a name="" id="" class="btn btn-success btn-lg" href="Buscador.php?addIDp=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                    </form>
                    <?php }?>
                    </div>
                    </br>
                    <?php }?>
                    <?php if($wishlist === false){?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?favIDp=<?php echo $id; ?>" role="button">Favorito</a>
                            </form>
                        <div>
                    <?php }else{ ?>
                        <div class="flex">
                            <form method="post">
                                <a name="" id="" class="btn btn-danger btn-lg" href="Buscador.php?delIDp=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                            </form>
                        <div>
                    <?php }?>
                    </br>
                    <p><a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</i></a></p>
                    </td>
                </table>
            </div>
            </div>
        <?php } ?>
    </body>      
<?php
}
?>