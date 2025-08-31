<?php include("header.php")?>
<section style="background-color: #f4f5f7;">
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-6 mb-4 mb-lg-0">
          <div class="card mb-3" style="border-radius: .5rem;">
            <div class="row g-0">
              <div class="col-md-4 gradient-custom text-center text-black align-middle"
                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem; align-items:center;">
                </br></br></br>
                <h5><?php echo $_SESSION['Nombre'] ?></h5>
                <p><?php echo $_SESSION['Rut']?> - <?php echo $_SESSION['Dv'] ?></p>
                <a class="btn ext-black font-italic"  href="http://localhost/prestigetravels/Editar_Perfil.php">Editar Informacion</a>
                <i class="mb-5"></i>
              </div>
              <div class="col-md-8">
                <div class="card-body p-4">
                  <h6>Información</h6>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <h6>Correo Electrónico</h6>
                      <p class="text-muted"><?php echo $_SESSION['Correo']?></p>
                    </div>
                    <div class="col-6 mb-3">
                      <h6>Fecha de Nacimiento</h6>
                      <p class="text-muted"><?php echo $_SESSION['Fecha_Nacimiento'] ?></p>
                    </div>
                  </div>
                  <hr class="mt-0 mb-4">
                  <div class="row pt-1">
                    <div class="col-6 mb-3">
                      <a class="btn btn-danger text-white" type="button" href="http://localhost/prestigetravels/Wishlist.php">Favoritos <i class="fa fa-heart"></i></a>
                    </div>
                    <div class="col-6 mb-3">
                      <a class="btn btn-primary text-white" type="button" href="http://localhost/prestigetravels/Mis_compras.php">Mis Compras</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <h3>Mis Comentarios</h3>
  <?php
  $rut = $_SESSION['Rut'];
  $sentencia = $conexion->prepare("SELECT Id_compra, Tipo_paquete, Tipo_hotel FROM `compra` WHERE Id_usuario = '$rut'");
  $sentencia->execute();
  $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);

  foreach($lista as $registro){
    $id_compra = $registro['Id_compra'];
    $tipo_paq = $registro['Tipo_paquete'];
    $tipo_hotel = $registro['Tipo_hotel'];
    $sentencia = $conexion->prepare("SELECT * FROM `comentario` WHERE Id_compra = '$id_compra'");
    $sentencia->execute();
    $lista=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    if(count($lista) > 0){
      $c1 = $lista[0]['Cal1'];
      $c2 = $lista[0]['Cal2'];
      $c3 = $lista[0]['Cal3'];
      $c4 = $lista[0]['Cal4'];
      $Fecha = $lista[0]['Fecha_reseña'];
      $Text = $lista[0]['Comentario'];
  ?>
  <section>
      <div class="container my-5 py-5" >
          <div class="row d-flex justify-content-center" >
              <div class="col-md-12 col-lg-10">
                  <div class="card text-dark">
                      <div class="card-body p-4">
                          <div class="d-flex flex-start">
                              <div style="display: flex; width: 100%;">
                                  <div type="card" style="width: 75%;">
                                      <h6 class="fw-bold mb-1"><?php echo $_SESSION['Nombre'] ?></h6>
                                      <div class="d-flex align-items-center mb-3">
                                      <p class="mb-0"><?php echo $Fecha ?></p>
                                      </div>
                                      <p class="mb-0"><?php echo $Text ?></p>
                                  </div>
                                  <div type="card" style="text-align: right; width: 25%;">
                                      <?php if($tipo_hotel=== 1){?>
                                      <p><?php echo "Liempieza: " . $c1 ?>/5</p>
                                      <p><?php echo "Servicio: " . $c2 ?>/5</p>
                                      <p><?php echo "Decoración: " . $c3 ?>/5</p>
                                      <p><?php echo "Calidad de las Camas: " . $c4 ?>/5</p>
                                      <?php }?>
                                      <?php if($tipo_paq === 1){?>
                                      <p><?php echo "Calidad de Hoteles: " . $c1 ?>/5</p>
                                      <p><?php echo "Transporte: " . $c2 ?>/5</p>
                                      <p><?php echo "Servicio: " . $c3 ?>/5</p>
                                      <p><?php echo "Calidad/Precio: " . $c4 ?>/5</p>
                                      <?php }?>
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
  }
  ?>
</section>