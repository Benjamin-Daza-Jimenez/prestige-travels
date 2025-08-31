<?php include("header.php");
$num = rand(0,100);
if(isset($_SESSION['logueado'])){
    $id = $_SESSION['Rut'];

if(isset($_GET['aID'])){
    $sentencia = $conexion->prepare("UPDATE usuario SET Descuento = '1' WHERE Rut = '$id';");
    if($sentencia->execute() === true){
        $_SESSION['Descuento'] = 1;
        header('Location: Index.php');
    }
}
$desc=$_SESSION['Descuento'];?>

<body>
    <?php if($num >= 0 and $num <= 100 and $desc === 0){ ?>
        <div class='card' style="border-radius: .5rem; margin: 10px;">
            <div style="display: flex; align-items: stretch;">
                <div style="width: 40%; text-align: center;">
                    <h1 style="margin-top: 10px;">¡¡Oferta Exclusiva solo para ti!!</h1>
                </div>
                <div style="width: 40%; text-align: center;">
                    <h3>¡¡Acabas de ser premiado por un cupón del 10% en el total de tu compra!!</h3>
                </div>
                <div style="width: 20%; text-align: center;">
                    <h4>¿Deseas Aceptarlo?</h4>
                    <a name="" id="" class="btn btn-success btn-sm" href="Index.php?aID=<?php echo $id; ?>" role="button">Aceptar</a>
                    <a name="" id="" class="btn btn-danger btn-sm" href="Index.php" role="button">Rechazar</a>
                </div>
            </div>
        </div>
    <?php }}?>
    <!-- Slices de las ofertas -->
    <div id="carouselExampleIndicators" class="carousel slide">
        <?php
            $sentencia1 = $conexion->prepare("SELECT * FROM `hotel` ORDER BY `hotel`.`Habitaciones_Totales` DESC");
            $sentencia1->execute();
            $lista1 = $sentencia1->fetchAll(PDO::FETCH_ASSOC);
            $hotel1 = $lista1[0];
            $hotel2 = $lista1[1];

            $sentencia2 = $conexion->prepare("SELECT * FROM `paquete` ORDER BY `paquete`.`Paquetes_Disponibles` DESC");
            $sentencia2->execute();
            $lista2 = $sentencia2->fetchAll(PDO::FETCH_ASSOC);
            $paquete1 = $lista2[0];
            $paquete2 = $lista2[1];
        ?>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="position: relative;">
                <a href="Pagina_plantilla.php?IDh=<?php echo $hotel1['Id_Hotel']; ?>"><img src="<?php echo $hotel1['Url_img']?>" class="d-block w-100"></a>
                <div style="position: absolute; top: 5%; left: 5%; width:650px; height:200px; background-color: white; opacity: 65%;">
                    <h1 style="width:95%; position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%);"><?php echo $hotel1['Nombre_Hotel'] ?></h1>
                    <h2 style="width:95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><?php echo $hotel1['Habitaciones_Disponibles'] ?> Habitaciones disponibles</h2>
                    <h2 style="width:95%; position: absolute; top: 75%; left: 50%; transform: translate(-50%, -50%);">A tan solo $<?php echo $hotel1['Precio_Noche'] ?> por noche</h2>
                </div>
            </div>
            <div class="carousel-item">
                <a href="Pagina_plantilla.php?IDp=<?php echo $paquete1['ID_Paquete']; ?>"><img src="<?php echo $paquete1['Url_img']?>" class="d-block w-100" ></a>
                <div style="position: absolute; top: 5%; left: 5%; width:650px; height:200px; background-color: white; opacity: 65%;">
                    <h1 style="width:95%; position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%);"><?php echo $paquete1['Nombre_paquete'] ?></h1>
                    <h2 style="width:95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><?php echo $paquete1['Paquetes_Disponibles'] ?> Paquetes disponibles</h2>
                    <h2 style="width:95%; position: absolute; top: 75%; left: 50%; transform: translate(-50%, -50%);">A tan solo $<?php echo $paquete1['Precio_Persona'] ?> por persona</h2>
                </div>
            </div>
            <div class="carousel-item">
                <a href="Pagina_plantilla.php?IDh=<?php echo $hotel2['Id_Hotel']; ?>"><img src="<?php echo $hotel2['Url_img']?>" class="d-block w-100"></a>
                <div style="position: absolute; top: 5%; left: 5%; width:650px; height:200px; background-color: white; opacity: 65%;">
                    <h1 style="width:95%; position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%);"><?php echo $hotel2['Nombre_Hotel'] ?></h1>
                    <h2 style="width:95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><?php echo $hotel2['Habitaciones_Disponibles'] ?> Habitaciones disponibles</h2>
                    <h2 style="width:95%; position: absolute; top: 75%; left: 50%; transform: translate(-50%, -50%);">A tan solo $<?php echo $hotel2['Precio_Noche'] ?> por noche</h2>
                </div>
            </div>
            <div class="carousel-item">
                <a href="Pagina_plantilla.php?IDp=<?php echo $paquete2['ID_Paquete']; ?>"><img src="<?php echo $paquete2['Url_img']?>" class="d-block w-100"></a>
                <div style="position: absolute; top: 5%; left: 5%; width:650px; height:200px; background-color: white; opacity: 65%;">
                    <h1 style="width:95%; position: absolute; top: 20%; left: 50%; transform: translate(-50%, -50%);"><?php echo $paquete2['Nombre_paquete'] ?></h1>
                    <h2 style="width:95%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><?php echo $paquete2['Paquetes_Disponibles'] ?> Paquetes disponibles</h2>
                    <h2 style="width:95%; position: absolute; top: 75%; left: 50%; transform: translate(-50%, -50%);">A tan solo $<?php echo $paquete2['Precio_Persona'] ?> por persona</h2>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Terminan slices de las ofertas -->
    <br/>
    <!-- Cuadros de abajo -->
    <div class="row align-items-md-stretch justify-content-center">
        <div class="col-md-5" id="cuadroIzq" style="margin-right: 5%;">
            <div
                class="h-100 p-5 bg-white border rounded-3"  >
                <h2>Paquetes de viaje</h2>
                <p>Aquí podras ver el listado de Paquetes de viaje para tus próximos viajes.</p>
                <a class="btn btn-outline-primary text-black" type="button" href="http://localhost/prestigetravels/Paquetes.php">Ver Paquetes de Viaje</a>
            </div>
        </div>
        <div class="col-md-5">
            <div
                class="h-100 p-5 border bg-white rounded-3" id="cuadroDer">
                <h2>Hoteles</h2>
                <p>Aquí podras ver el listado de Hoteles para tus próximos viajes.</p>
                <a class="btn btn-outline-primary text-black" type="button" href="http://localhost/prestigetravels/Hoteles.php">Ver Hoteles</a>
            </div>
        </div>
    </div>
    <br/>
    <div class="row align-items-md-stretch justify-content-center">
        <div class="col-md-5" id="cuadroIzq" style="margin-right: 5%;">
            <div
                class="h-100 p-5 bg-white border rounded-3"  >
                <h2>Los Mejores Paquetes de viaje</h2>
                <p>Aquí podras ver el listado de los 10 mejores Paquetes de viaje para tus próximos viajes.</p>
                <a class="btn btn-outline-primary text-black" type="button" href="http://localhost/prestigetravels/Paquetes_Top10.php">Ver Paquetes de Viaje</a>
            </div>
        </div>
        <div class="col-md-5">
            <div
                class="h-100 p-5 border bg-white rounded-3" id="cuadroDer">
                <h2>Los Mejores Hoteles</h2>
                <p>Aquí podras ver el listado de los 10 mejores Hoteles para tus próximos viajes.</p>
                <a class="btn btn-outline-primary text-black" type="button" href="http://localhost/prestigetravels/Hoteles_Top10.php">Ver Hoteles</a>
            </div>
        </div>
    </div>
    <br/>
    <?php include("footer.php");?>
</body>