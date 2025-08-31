<?php include("header.php");
ob_start();
$sentencia=$conexion->prepare("SELECT * FROM `paquete`");
$sentencia->execute();
$lista_paquetes=$sentencia->fetchAll(PDO::FETCH_ASSOC);

if(isset($_SESSION['logueado'])){
    $rut = $_SESSION['Rut'];
}
if(isset($_GET['favID'])){
    $ID = $_GET['favID'];
    $sentencia = $conexion->prepare("INSERT INTO `wishlist`(`Id_fav`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`) VALUES (NULL,'$rut',0,1,NULL,'$ID')");
    if($sentencia->execute() === true){
        header('Location: Paquetes.php');
    }
}

if(isset($_GET['delID'])){
    $ID = $_GET['delID'];
    $sentencia = $conexion->prepare("DELETE FROM `wishlist` WHERE Id_paquete = $ID");
    if($sentencia->execute() === true){
        header('Location: Paquetes.php');
    }
}

if(isset($_GET['addID'])){
    $ID = $_GET['addID'];
    $sentencia = $conexion->prepare("INSERT INTO `carrito`(`Id_carrito`,`Id_usuario`,`Tipo_hotel`,`Tipo_paquete`,`Id_hotel`,`Id_paquete`,`Personas_paq`) VALUES (NULL,'$rut',0,1,NULL,'$ID',1)");
    if($sentencia->execute() === true){
        header('Location: Paquetes.php');
    }
}?>

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
                if(count($lista_carrrito) < $disponibles and isset($_SESSION['logueado'])){ 
                ?>
                <form method="post">
                    <a name="" id="" class="btn btn-success btn-lg" href="Paquetes.php?addID=<?php echo $id; ?>" role="button">Añadir al Carrito</a>
                </form>
                <?php }?>
                </div>
                </br>
                <?php }?>
                <?php if(isset($_SESSION['logueado'])){ 
                if($wishlist === false){?>
                    <div class="flex">
                        <form method="post">
                            <a name="" id="" class="btn btn-danger btn-lg" href="Paquetes.php?favID=<?php echo $id; ?>" role="button">Favorito</a>
                        </form>
                    <div>
                <?php }else{ ?>
                    <div class="flex">
                        <form method="post">
                            <a name="" id="" class="btn btn-danger btn-lg" href="Paquetes.php?delID=<?php echo $id; ?>" role="button">Eliminar de Favorito</a>
                        </form>
                    <div>
                <?php
                    } 
                }?>
                </br>
                <p><a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</i></a></p>
                </td>
            </table>
        </div>
        </div>
    <?php } ?>
</body>