<?php
ob_start();
include("header.php");?>
<body>
    <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registro de Hoteles</p>

                    <form class="mx-1 mx-md-4" action="Añadir_Hoteles.php" method="POST">
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Nombre" id="Nombre" class="form-control" required />
                            <label class="form-label" for="Nombre">Nombre hotel</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Estrellas" id="Estrellas" class="form-control" required />
                            <label class="form-label" for="Estrellas">Estrellas</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Precio" id="Precio" class="form-control" required />
                            <label class="form-label" for="Precio">Precio por noche</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Ciudad" id="Ciudad" class="form-control" required />
                            <label class="form-label" for="Ciudad">Ciudad</label>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Habitacionest" id="Habitacionest" class="form-control" required />
                            <label class="form-label" for="Habitacionest">Habitaciones totales</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Habitacionesd" id="Habitacionesd" class="form-control" required />
                            <label class="form-label" for="Habitacionesd">Habitaciones disponibles</label>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Estacionamiento" id="Estacionamiento" class="form-control" required />
                            <label class="form-label" for="Estacionamiento">Estacionamiento</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Piscina" id="Piscina" class="form-control" required  />
                            <label class="form-label" for="Piscina">Piscina</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Lavanderia" id="Lavanderia" class="form-control" required  />
                            <label class="form-label" for="Lavanderia">Lavanderia</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Pet" id="Pet" class="form-control" required  />
                            <label class="form-label" for="Pet">Pet friendly</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Desayuno" id="Desayuno" class="form-control" required  />
                            <label class="form-label" for="Desayuno">Desayuno</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        </div>
                    </form>

                    <!-- Enviar Datos a la BD -->
                    <div>
                        <?php
                            
                            
                            
                            if(isset($_POST['Nombre']) and isset($_POST['Estrellas']) and isset($_POST['Precio']) and isset($_POST['Ciudad']) and isset($_POST['Habitacionest']) and isset($_POST['Habitacionesd']) and isset($_POST['Estacionamiento']) and isset($_POST['Piscina']) and isset($_POST['Lavanderia']) and isset($_POST['Pet']) and isset($_POST['Desayuno'])){
                                $Nombre = $_POST['Nombre'];
                                $Estrellas = $_POST['Estrellas'];
                                $Precio = $_POST['Precio'];
                                $Ciudad = $_POST['Ciudad'];
                                $Habitacionest = $_POST['Habitacionest'];
                                $Habitacionesd = $_POST['Habitacionesd'];
                                $Estacionamiento = $_POST['Estacionamiento'];
                                $Piscina = $_POST['Piscina'];
                                $Lavanderia = $_POST['Lavanderia'];
                                $Pet = $_POST['Pet'];
                                $Desayuno = $_POST['Desayuno'];
                                $sql = $conexion->prepare("INSERT INTO `hotel` (`Id_Hotel`, `Nombre_Hotel`, `Estrellas`, `Precio_Noche`, `Ciudad`, `Habitaciones_Totales`, `Habitaciones_Disponibles`, `Estacionamiento`, `Piscina`, `Lavanderia`, `Pet_Friendly`, `Desayuno`) VALUES( NULL,'$Nombre', '$Estrellas', '$Precio', '$Ciudad', '$Habitacionest', '$Habitacionesd', '$Estacionamiento', '$Piscina', '$Lavanderia', '$Pet', '$Desayuno')");
                            ?>
                            <?php
                                if($sql->execute() === true){
                                    $sql = $conexion->prepare("SELECT Id_Hotel FROM hotel WHERE Nombre_Hotel='$Nombre' AND Precio_Noche='$Precio' AND Ciudad='$Ciudad';");
                                    $sql->execute();
                                    $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    $id = $lista[0]['Id_Hotel'];
                                    $url="Recursos/$Nombre $id.jpg";
                                    $sql = $conexion->prepare("UPDATE hotel SET Url_Img = '$url' WHERE Id_Hotel = '$id'");
                                    $sql->execute();
                                    header('Location: Index.php');
                            ?>
                                <div class="alert alert-success" role="alert">Se ha Registrado con éxito</div>
                            <?php
                                } 
                                else{
                            ?>      <div class="alert alert-danger" role="alert">Se ha Registrado con éxito</div>
                        <?php
                                } 
                            }
                        ?>
                    </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>