<?php
include("header.php");
?>
<section style="background-color: #d94125;">
  <div class="container my-5 py-5 text-dark">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10 col-lg-8 col-xl-6">
        <div class="card">
          <div class="card-body p-4">
            <div class="d-flex flex-start w-100">
              <div class="w-100">
                <h5>Añade un comentario</h5>
                <?php 
                $ID_compra = $_GET['ID'];
                $sentencia = $conexion->prepare("SELECT * FROM `compra` WHERE Id_Compra = $ID_compra");
                $sentencia->execute();
                $lista = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                $registro = $lista[0];
                if($registro['Tipo_hotel'] === 1){
                ?>
                <form method="post" action="Enviar_comentario.php?IDth=<?php echo $ID_compra?>">
                    <p><i class="fa fa-star fa-sm text-danger"></i> Limpieza</p>
                    <select name="Limpieza">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger"></i> Servicio</p>
                    <select name="Servicio_">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger"></i> Decoración</p>
                    <select name="Decoracion">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger"></i> Calidad camas</p>
                    <select name="Camas">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <div class="form-outline">
                        <textarea class="form-control" name="Text" rows="4"></textarea>
                    </div>
                    </br>
                    <input type="submit" value="Enviar">
                </form>
                <?php
                }

                if($registro['Tipo_paquete'] === 1){ ?>
                <form method="post" action="Enviar_comentario.php?IDtp=<?php echo $ID_compra?>">
                    <p><i class="fa fa-star fa-sm text-danger" ></i> Calidad de hoteles: </p>
                    <select name="Calidad">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger" ></i> Transporte: </p>
                    <select name="Transporte" id="">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger"></i> Servicio: </p>
                    <select name="Servicio" id="">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <p><i class="fa fa-star fa-sm text-danger"></i> Relación precio-calidad: </p>
                    <select name="RPC" id="">
                        <option value="1">Mediocre</option>
                        <option value="2">Mala</option>
                        <option value="3">Normal</option>
                        <option value="4">Buena</option>
                        <option value="5">Excelente</option>
                    </select>
                    </br>
                    <div class="form-outline">
                        <textarea class="form-control" name="Text" rows="4"></textarea>
                    </div>
                    </br>
                    <input type="submit" value="Enviar">
                </form>
                <?php }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>