<?php
session_start();
// CONEXION A LA BD
$servidor = "localhost";
$baseDeDatos = "Prestigetravels";
$usuario = "root";
$contrasenia = "";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
}catch(Exception $ex){
    echo $ex->getMessage();
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Prestige Travels</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://localhost/prestigetravels/Index.php">Prestige Travels</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Index.php">Home</a>
        </li>
        <?php if(isset($_SESSION['logueado'])){?>
            <li>
              <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Pagina_Personal.php"><?php echo $_SESSION['Nombre']?></a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Cerrar_Sesion.php">Cerrar Sesión</a>
            </li>
        <?php if($_SESSION['Admin'] === 1){?>
              <!-- Admin -->
              <li>
                <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Añadir_Paquetes.php">Registrar Paquetes</a>
              </li>
              <li>
                <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Añadir_Hoteles.php">Registrar Hoteles</a>
              </li>
            <?php }
            }else{?>
          <li>
            <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Iniciar_Sesion.php">Iniciar Sesión</a>
          </li>
          <li>
            <a class="nav-link active" aria-current="page" href="http://localhost/prestigetravels/Registro.php">Registrar Cuenta</a>
          </li>
        <?php } ?>
        <li>
          <a class = "nav-link active" aria-current="page" href="http://localhost/prestigetravels/Carrito.php">Carrito<i class="fa fa-shopping-cart"></i></a>
        </li>
      </ul>

      <form class="d-flex" action="Buscador.php" method="post">
        <input name="Palabra" id="Palabra" class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>