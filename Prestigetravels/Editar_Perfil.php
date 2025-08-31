<?php 
ob_start();
include("header.php")?>
<body>
    <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
                <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Editar Información</p>                    
                    <form class="mx-1 mx-md-4" action="Editar_Perfil.php" method="POST">
                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            Cambie la información que estime necesario
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="text" name="Nombre" id="Nombre" class="form-control"/>
                            <label class="form-label" for="Nombre">Nombre</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="email" name="Correo" id="Correo" class="form-control"/>
                            <label class="form-label" for="Correo">Correo Electrónico</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                            <input type="password" name="Contraseña" id="Contraseña" class="form-control"/>
                            <label class="form-label" for="Contraseña">Contraseña</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" class="btn btn-primary btn-lg">Cambiar</button>
                        </div>
                    </form>
                    <!-- Actualizar información en la BD -->
                    <?php

                        if(isset($_POST['Nombre']) or isset($_POST['Correo']) or isset($_POST['Contraseña'])){
                            $rut = $_SESSION['Rut'];
                            if(isset($_POST['Nombre']) and $_POST['Nombre'] != null){
                                $NombreNuevo = $_POST['Nombre'];
                                $sql = $conexion->prepare("UPDATE usuario SET Nombre = '$NombreNuevo' WHERE Rut = '$rut';");
                                if($sql->execute() === true){
                                    $_SESSION['Nombre'] = $NombreNuevo;   
                                }
                            }
                            if(isset($_POST['Correo']) and $_POST['Correo'] != null){
                                $CorreoNuevo = $_POST['Correo'];
                                $sql = $conexion->prepare("UPDATE usuario SET Correo = '$CorreoNuevo' WHERE Rut = '$rut';");
                                if($sql->execute() === true){
                                    $_SESSION['Correo'] = $CorreoNuevo;   
                                }
                            }
                            if(isset($_POST['Contraseña']) and $_POST['Contraseña'] != null){
                                $ContraseñaNuevo = $_POST['Contraseña'];
                                $sql = $conexion->prepare("UPDATE usuario SET Contraseña = '$ContraseñaNuevo' WHERE Rut = '$rut';");
                                if($sql->execute() === true){
                                    $_SESSION['Contraseña'] = $ContraseñaNuevo;   
                                }
                            }
                            header("Location: Editar_Perfil.php");
                        }

                    ?>
                    <!-- Actualizar información en la BD -->
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>