<?php 
ob_start();
include("header.php");
$rut = $_SESSION['Rut'];
$sentencia=$conexion->prepare("SELECT * FROM `compra` WHERE Id_usuario=$rut");
$sentencia->execute();
$lista_hoteles=$sentencia->fetchAll(PDO::FETCH_ASSOC);?>

<body>
    <?php foreach($lista_hoteles as $registro) {
        if($registro['Tipo_hotel'] === 1){
            $Id = $registro['Id_hotel'];
            $sentencia = $conexion->prepare("SELECT * FROM `hotel` WHERE Id_Hotel=$Id");
            $sentencia->execute();
            $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $nom = $lista[0]['Nombre_Hotel'];
            ?>

            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:30%">
                        <h2 class="card-title"><?php echo $lista[0]['Nombre_Hotel']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $lista[0]['Estrellas']?> / 5</i></p>
                        <p class="card-text">Número de compra: #<?php echo $registro['Id_Compra']?></p>
                        <p class="card-text">Fecha de compra: <?php echo $registro['Fecha_compra']?></p>
                        <p class="card-text">Esta compra está asignada para <?php echo $registro['Noches_hotel']?> noches</p>
                        <?php if($registro['Descuento'] === 1){?>
                        <p class="card-text">Se le ha asignado un 10% de descuento en su compra</p>
                        <p class="card-text">Monto pagado por la compra: $<?php echo ($registro['Noches_hotel'] * $lista[0]['Precio_Noche'])*0.9 ?></p>
                        <?php }else{?>
                            <p class="card-text">Monto pagado por la compra: $<?php echo ($registro['Noches_hotel'] * $lista[0]['Precio_Noche']) ?></p>
                        <?php }?>
                    </td>
                    <td class = "card-body" style ="width:20%">
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDh=<?php echo $Id; ?>" role="button">Ir al Sitio</a>
                        </br></br>
                        <a name="" id="" class="btn btn-secondary btn-lg" href="Comentario.php?ID=<?php echo $registro['Id_Compra']; ?>" role="button">Calificar</a>
                    </tod>
                    <td class = "card-body"style ="width:50%; text-align: center;">
                        <!-- Mostrar imagen -->
                        <img src = '<?php echo $lista[0]['Url_img']?>' width=" 90%" >
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
            <div class="card mb-3">
            <div class="card-body">
                <table>
                    <td class = "card-body" style ="width:30%">
                        <h2 class="card-title"><?php echo $lista[0]['Nombre_paquete']?></h2>
                        <p class="card-text"><i class="fa fa-star">    <?php echo $lista[0]['Estrellas']?> / 5</i></p>
                        <p class="card-text">Número de compra: #<?php echo $registro['Id_Compra']?></p>
                        <p class="card-text">Fecha de compra: <?php echo $registro['Fecha_compra']?></p>
                        <p class="card-text">Esta compra está asignada para <?php echo $registro['Personas_paq']?> personas</p>
                        <?php if($registro['Descuento'] === 1){?>
                        <p class="card-text">Se le ha asignado un 10% de descuento en su compra</p>
                        <p class="card-text">Monto pagado por la compra: $<?php echo ($registro['Personas_paq'] * $lista[0]['Precio_Persona'])*0.9 ?></p>
                        <?php }else{?>
                            <p class="card-text">Monto pagado por la compra: $<?php echo ($registro['Personas_paq'] * $lista[0]['Precio_Persona']) ?></p>
                        <?php }?>
                    </td>
                    <td class = "card-body" style ="width:20%; text-align: center;">
                        <a name="" id="" class="btn btn-primary btn-lg" href="Pagina_plantilla.php?IDp=<?php echo $id; ?>" role="button">Ir al Sitio</a>
                        </br></br>
                        <a name="" id="" class="btn btn-secondary btn-lg" href="Comentario.php?ID=<?php echo $registro['Id_Compra']; ?>" role="button">Calificar</a>
                    </td>
                    <td class = "card-body"style ="width:50%; text-align: center;">
                        <!-- Mostrar imagen -->
                        <img src = '<?php echo $lista[0]['Url_img']?>' width="90%" >
                    </td>
                        <!-- Recuadro vacio de la derecha -->
                </table>
            </div>
            </div>
        <?php }
    } ?>
</body>