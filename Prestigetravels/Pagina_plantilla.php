<!-- Mostrar hotel -->
<?php
include('header.php');
if(isset($_GET['IDh'])){
    $ID = $_GET['IDh'];
    $sentencia=$conexion->prepare("SELECT * FROM `hotel` WHERE $ID = Id_Hotel");
    $sentencia->execute();
    $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $registro = $lista[0];
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
    }?>

    <section style="background-color: #f4f5f7;">
        <div class="container py-4 h-150">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="py-4 h-100">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="card-body p-4">
                                <h1><?php echo $registro['Nombre_Hotel']?></h1>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <p>Precio por noche: $<?php echo $registro['Precio_Noche']?></p>
                                        <p>Ubicado en <?php echo $registro['Ciudad']?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p>Tiene un total de <?php echo $registro['Habitaciones_Totales']?> habitaciones</p>
                                        <p>Tiene disponible <?php echo $registro['Habitaciones_Disponibles']?> habitaciones</p>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <p><i class="fa fa-car"> Estacionamiento: <?php echo $est?></i></p>
                                        <p><i class="fa fa-life-ring"> Piscina: <?php echo $pis?></i></p>
                                        <p><i class="fa fa-tint"> Lavanderia: <?php echo $lav?></i></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p><i class="fa fa-cutlery"> Desayuno: <?php echo $des?></i></p>
                                        <p><i class="fa fa-paw"> Petfriendly: <?php echo $pet?></i></p>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">
                                <div>
                                    <img src = '<?php echo $registro['Url_img']?>' width="100%" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php 
    $sentencia = $conexion->prepare("SELECT Id_compra FROM `compra` WHERE Id_hotel = '$ID'");
    $sentencia->execute();
    $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    foreach($lista as $registro){
        $id_compra = $registro['Id_compra'];
        $sentencia = $conexion->prepare("SELECT * FROM `comentario` WHERE Id_compra = '$id_compra'");
        $sentencia->execute();
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $rut = $lista[0]['Id_usuario'];
        $c1 = $lista[0]['Cal1'];
        $c2 = $lista[0]['Cal2'];
        $c3 = $lista[0]['Cal3'];
        $c4 = $lista[0]['Cal4'];
        $Fecha = $lista[0]['Fecha_reseña'];
        $Text = $lista[0]['Comentario'];

        $sentencia = $conexion->prepare("SELECT Nombre FROM `usuario` WHERE Rut = '$rut'");
        $sentencia->execute();
        $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $Nombre = $lista[0]['Nombre'];
    ?>

        <section style="background-color: #f4f5f7;">
                <h3 class="mb-0">Comentarios</h3>
                <div class="container my-5 py-5" >
                    <div class="row d-flex justify-content-center" >
                        <div class="col-md-12 col-lg-10">
                            <div class="card text-dark">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-start">
                                        <div style="display: flex; width: 100%;">
                                            <div type="card" style="width: 75%;">
                                                <h6 class="fw-bold mb-1"><?php echo $Nombre ?></h6>
                                                <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0"><?php echo $Fecha ?></p>
                                                </div>
                                                <p class="mb-0"><?php echo $Text ?></p>
                                            </div>
                                            <div type="card" style="text-align: right; width: 25%;">
                                                <p><?php echo "Liempieza: " . $c1 ?>/5</p>
                                                <p><?php echo "Servicio: " . $c2 ?>/5</p>
                                                <p><?php echo "Decoración: " . $c3 ?>/5</p>
                                                <p><?php echo "Calidad de las Camas: " . $c4 ?>/5</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-0" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

<?php 
    }

}?>


<!-- Mostrar paquete -->
<?php
if(isset($_GET['IDp'])){
    $ID = $_GET['IDp'];
    $sentencia=$conexion->prepare("SELECT * FROM `paquete` WHERE $ID = ID_Paquete");
    $sentencia->execute();
    $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $registro = $lista[0];

    $idh=$registro['Id_Hospedaje'];
    $idc=$registro['Id_Ciudad'];

    $consultah=$conexion->prepare("SELECT * FROM `hospedaje` WHERE Id_hospedaje = $idh");
    $consultah->execute();
    $listah = $consultah->fetchAll(PDO::FETCH_ASSOC);
    
    $consultac=$conexion->prepare("SELECT * FROM `ciudad` WHERE Id_Ciudad = $idc");
    $consultac->execute();
    $listac = $consultac->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section style="background-color: #f4f5f7;">
        <div class="container py-4 h-150">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="py-4 h-100">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="card-body p-4">
                                <h1><?php echo $registro['Nombre_paquete']?></h1>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <p class="card-text">Precio por persona: $<?php echo $registro['Precio_Persona']?></p>
                                        <p><i class="fa fa-users"> Con un total de hasta <?php echo $registro['Personas_Maximo']?> personas</i></p>
                                        <p class="card-text">Tiene un total de <?php echo $registro['Paquetes_Totales']?> paquetes</p>
                                        <p class="card-text">Tiene disponible <?php echo $registro['Paquetes_Disponibles']?> paquetes</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <p><i class="fa fa-plane"> Aerolínea de ida: <?php echo $registro['Aerolinea_Ida']?></i></p>
                                        <p><i class="fa fa-plane"> Aerolínea de vuelta: <?php echo $registro['Aerolinea_Vuelta']?></i></p>
                                        <p class="card-text">Fecha salida: <?php echo $registro['Fecha_Salida']?></p>
                                        <p class="card-text">Fecha llegada: <?php echo $registro['Fecha_Vuelta']?></p>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h4>Hoteles</h4>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H1']?></p>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H2']?></p>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listah[0]['H3']?></p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h4>Hospedajes</h4>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C1']?></p>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C2']?></p>
                                        <p><?php echo str_repeat('&nbsp;', 10) . $listac[0]['C3']?></p>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">
                                <div>
                                    <img src = '<?php echo $registro['Url_img']?>' width="100%" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php 
    $sentencia = $conexion->prepare("SELECT Id_compra FROM `compra` WHERE Id_paquete = '$ID'");
    $sentencia->execute();
    $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    print_r($lista);

    foreach($lista as $registro){
        $id_compra = $registro['Id_compra'];
        $sentencia = $conexion->prepare("SELECT * FROM `comentario` WHERE Id_compra = '$id_compra'");
        $sentencia->execute();
        $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        $rut = $lista[0]['Id_usuario'];
        $c1 = $lista[0]['Cal1'];
        $c2 = $lista[0]['Cal2'];
        $c3 = $lista[0]['Cal3'];
        $c4 = $lista[0]['Cal4'];
        $Fecha = $lista[0]['Fecha_reseña'];
        $Text = $lista[0]['Comentario'];

        $sentencia = $conexion->prepare("SELECT Nombre FROM `usuario` WHERE Rut = '$rut'");
        $sentencia->execute();
        $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $Nombre = $lista[0]['Nombre'];
    ?>
        
        <section style="background-color: #f4f5f7;">
            <h3 class="mb-0">Comentarios</h3>
            <div class="container my-5 py-5" >
                <div class="row d-flex justify-content-center" >
                    <div class="col-md-12 col-lg-10">
                        <div class="card text-dark">
                            <div class="card-body p-4">
                                <div class="d-flex flex-start">
                                    <div style="display: flex; width: 100%;">
                                        <div type="card" style="width: 75%;">
                                            <h6 class="fw-bold mb-1"><?php echo $Nombre ?></h6>
                                            <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0"><?php echo $Fecha ?></p>
                                            </div>
                                            <p class="mb-0"><?php echo $Text ?></p>
                                        </div>
                                        <div type="card" style="text-align: right; width: 25%;">
                                            <p><?php echo "Calidad de Hoteles: " . $c1 ?>/5</p>
                                            <p><?php echo "Transporte: " . $c2 ?>/5</p>
                                            <p><?php echo "Servicio: " . $c3 ?>/5</p>
                                            <p><?php echo "Calidad/Precio: " . $c4 ?>/5</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-0" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}?>