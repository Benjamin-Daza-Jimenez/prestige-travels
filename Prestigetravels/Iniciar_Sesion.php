<?php 
    include("header.php");
    if($_POST){
        $sentencia = $conexion->prepare("SELECT *,count(*) as n_usuarios FROM `usuario` WHERE Correo=:Correo AND Contraseña=:Pasword;");

        $correo = $_POST["Correo"];
        $pasword = $_POST["Pasword"];

        $sentencia->bindParam(":Correo",$correo);
        $sentencia->bindParam(":Pasword",$pasword);
        $sentencia->execute();

        $sesion = $sentencia->fetch(PDO::FETCH_LAZY);
        
        if($sesion["n_usuarios"]>0){
            $_SESSION['Nombre'] = $sesion['Nombre'];
            $_SESSION['Rut'] = $sesion['Rut'];
            $_SESSION['Dv'] = $sesion['Dv'];
            $_SESSION['Correo'] = $sesion['Correo'];
            $_SESSION['Fecha_Nacimiento'] = $sesion['Fecha_Nacimiento'];
            $_SESSION['logueado'] = true;
            $_SESSION['Admin'] = $sesion['Admin'];
            $_SESSION['Descuento'] = $sesion['Descuento'];
            header("Location:Index.php");
        }
        else{
            $mensaje = "Error: El usuario y/o contraseña son incorrectos.";
        }
        
    }
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

                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Inicio de sesión</p>
                    
                    <?php if(isset($mensaje)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $mensaje?></strong>
                        </div>
                    <?php } ?>

                    <form class="mx-1 mx-md-4" action="Iniciar_Sesion.php" method="POST">


                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                        <input type="email" id="Correo" name="Correo" class="form-control" />
                        <label class="form-label" for="form3Example3c">Correo Electrónico</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                        <input type="password" id="Pasword" name="Pasword" class="form-control" />
                        <label class="form-label" for="form3Example4c">Contraseña</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                    </div>

                    </form>

                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
</body>