<?php 
ob_start();
include("header.php");
?>

<body>
    <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registro de Paquetes</p>

                    <form class="mx-1 mx-md-4" action="Añadir_Paquetes.php" method="POST">

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Ciudades</p>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="c1" id="c1" class="form-control" required />
                            <label class="form-label" for="c1">Ciudad 1</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="c2" id="c2" class="form-control"/>
                            <label class="form-label" for="c2">Ciudad 2</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="c3" id="c3" class="form-control"/>
                            <label class="form-label" for="c3">Ciudad 3</label>
                            </div>
                        </div>

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Hospedajes</p>
                        
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="h1" id="h1" class="form-control" required />
                            <label class="form-label" for="h1">Hospedaje 1</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="h2" id="h2" class="form-control"/>
                            <label class="form-label" for="h2">Hospedaje 2</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="h3" id="h3" class="form-control"/>
                            <label class="form-label" for="h3">Hospedaje 3</label>
                            </div>
                        </div>

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Paquete</p>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Nombre" id="Nombre" class="form-control" required />
                            <label class="form-label" for="Nombre">Nombre del paquete</label>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Aida" id="Aida" class="form-control" required />
                            <label class="form-label" for="Aida">Aerolinea de ida</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Avuelta" id="Avuelta" class="form-control" required />
                            <label class="form-label" for="Avuelta">Aerolinea de vuelta</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input placeholder="Select date" name="Fsalida" type="date" id="Fsalida" class="form-control" format="yyyy/mm/dd" required >
                            <label class="form-label" for="Fsalida">Fecha de Salida</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input placeholder="Select date" name="Fvuelta" type="date" id="Fvuelta" class="form-control" format="yyyy/mm/dd" required >
                            <label class="form-label" for="Fvuelta">Fecha de vuelta</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Price" id="Price" class="form-control" required  />
                            <label class="form-label" for="Price">Precio por persona</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Pmax" id="Pmax" class="form-control" required  />
                            <label class="form-label" for="Pmax">Personas maximo</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Padisp" id="Padisp" class="form-control" required  />
                            <label class="form-label" for="Padisp">Paquetes disponibles</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Patot" id="Patot" class="form-control" required  />
                            <label class="form-label" for="Patot">Paquetes totales</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        </div>
                    </form>

                    <!-- Enviar Datos a la BD -->
                    <div>
                        <?php
                            //Enviar a la base de ciudad

                            if(isset($_POST['c1']) or isset($_POST['c2']) or isset($_POST['c3'])){
                                $c1 = $_POST['c1'];
                                $c2 = $_POST['c2'];
                                $c3 = $_POST['c3'];
                                $sql = $conexion->prepare("INSERT INTO `ciudad` (`Id_Ciudad`, `C1`, `C2`, `C3`) VALUES( NULL,'$c1', '$c2', '$c3');");
                                if($sql->execute() === true){
                                    echo '';
                                }
                                $sentencia = $conexion->prepare("SELECT Id_Ciudad FROM `ciudad` WHERE C1='$c1' AND C2='$c2' AND C3='$c3';");
                                $sentencia->execute();
                                $idc_=$sentencia->fetchAll(PDO::FETCH_ASSOC);
                                $idc = $idc_[0]['Id_Ciudad'];
                            }?>

                        <?php
                            //Enviar a la base de hospedaje
                            if(isset($_POST['h1']) or isset($_POST['h2']) or isset($_POST['h3'])){
                                $h1 = $_POST['h1'];
                                $h2 = $_POST['h2'];
                                $h3 = $_POST['h3'];
                                $sql_ = $conexion->prepare("INSERT INTO `hospedaje` (`Id_hospedaje`, `H1`, `H2`, `H3`) VALUES( NULL,'$h1', '$h2', '$h3');");
                                if($sql_->execute() === true){
                                    echo '';
                                }
                                $sentencia2 = $conexion->prepare("SELECT Id_hospedaje FROM `hospedaje` WHERE H1='$h1' AND H2='$h2' AND H3='$h3';");
                                $sentencia2->execute();
                                $idh_=$sentencia2->fetchAll(PDO::FETCH_ASSOC);
                                $idh = $idh_[0]['Id_hospedaje'];
                            }?>
                        <?php
                            //Enviar a la base de paquete

                            if(isset($_POST['Nombre']) and isset($_POST['Aida']) and isset($_POST['Avuelta']) and isset($_POST['Fsalida']) and isset($_POST['Fvuelta']) and isset($_POST['Price']) and isset($_POST['Pmax']) and isset($_POST['Patot'])){
                                $Nombre = $_POST['Nombre'];
                                $Aida = $_POST['Aida'];
                                $Avuelta = $_POST['Avuelta'];
                                $Fsalida = $_POST['Fsalida'];
                                $Fsalida = date("Y-m-d", strtotime($Fsalida));
                                $Fvuelta = $_POST['Fvuelta'];
                                $Fvuelta = date("Y-m-d", strtotime($Fvuelta));
                                $Price = $_POST['Price'];
                                $Pmax = $_POST['Pmax'];
                                $Padisp = $_POST['Padisp'];
                                $Patot = $_POST['Patot'];
                                $diff = date_diff(date_create($Fsalida),date_create($Fvuelta));
                                $noches = $diff->days;

                                $sql__ = $conexion->prepare("INSERT INTO `paquete` (`Id_Paquete`, `Id_Ciudad`, `Id_Hospedaje`, `Nombre_paquete`, `Aerolinea_Ida`, `Aerolinea_Vuelta`, `Fecha_Salida`, `Fecha_Vuelta`, `Noches_Totales`, `Precio_Persona`,`Paquetes_Disponibles`, `Paquetes_Totales`, `Personas_Maximo`) VALUES( NULL, '$idc', '$idh', '$Nombre', '$Aida', '$Avuelta', '$Fsalida', '$Fvuelta', '$noches', '$Price', '$Padisp', '$Patot', '$Pmax')");
                                
                                if($sql__->execute() === true){
                                    $sql = $conexion->prepare("SELECT ID_Paquete FROM paquete WHERE Nombre_paquete='$Nombre' AND Precio_Persona='$Price' AND Noches_Totales='$noches';");
                                    $sql->execute();
                                    $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
                                    $id = $lista[0]['ID_Paquete'];
                                    $url="Recursos/$Nombre $id.jpg";
                                    $sql = $conexion->prepare("UPDATE paquete SET Url_Img = '$url' WHERE ID_Paquete = '$id'");
                                    $sql->execute();
                                    header('Location: Index.php');?>
                            <?php } else{?>      
                                <div class="alert alert-danger" role="alert">No se ha Registrado</div>
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