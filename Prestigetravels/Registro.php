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

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registro</p>

                    <form class="mx-1 mx-md-4" action="Registro.php" method="POST">
                        <div class="row">
                            <div class="d-flex flex-row align-items-center mb-4 col-md-9">
                                <i class="fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="text" name="Rut" id="Rut" class="form-control" required />
                                <label class="form-label" for="Rut">Rut</label>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-row align-items-center mb-4 col-md-3">
                                <i class="fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="text" name="Dv" id="Dv" class="form-control" required />
                                <label class="form-label" for="Dv">Dv</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Nombre" id="Nombre" class="form-control" required />
                            <label class="form-label" for="Nombre">Nombre</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="email" name="Correo" id="Correo" class="form-control" required  />
                            <label class="form-label" for="Correo">Correo Electrónico</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="password" name="Contraseña" id="Contraseña" class="form-control" required />
                            <label class="form-label" for="Contraseña">Contraseña</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input placeholder="Select date" name="date" type="date" id="Fecha" class="form-control" format="yyyy/mm/dd" required >
                            <label class="form-label" for="date">Fecha de Nacimiento</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        </div>
                    </form>

                    <!-- Enviar Datos a la BD -->
                    <div>
                        <?php
                            if(isset($_POST['Rut']) and isset($_POST['Dv']) and isset($_POST['Nombre']) and isset($_POST['Correo']) and isset($_POST['Contraseña']) and isset($_POST['date'])){
                                $Rut = $_POST['Rut'];
                                $Dv = $_POST['Dv'];
                                $Nombre = $_POST['Nombre'];
                                $Correo = $_POST['Correo'];
                                $Contraseña = $_POST['Contraseña'];
                                $date = $_POST['date'];
                                $date = date("Y-m-d", strtotime($date));
                                $sql = $conexion->prepare("INSERT INTO usuario(Rut, Dv, Nombre, Fecha_Nacimiento, Correo, Contraseña, Descuento) VALUES('$Rut', '$Dv','$Nombre', '$date', '$Correo', '$Contraseña',0)");
                        ?><?php
                                if($sql->execute() === true){
                                    header('Location: Index.php');
                            ?>
                                    <div class="alert alert-success" role="alert">Se ha Registrado con éxito</div>
                            <?php
                                } 
                                else{
                            ?>      <div class="alert alert-danger" role="alert">Ha ocurrido un Error</div>
                        <?php
                                } 
                            }
                        ?>
                    </div>
                    <!-- Enviar Datos a la BD -->

                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>