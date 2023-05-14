<?php 

include("../../bd.php");

if($_POST && $_FILES){

  $primernombre=(isset($_POST["primernombre"]) ? $_POST["primernombre"] : "");
  $segundonombre=(isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : "");
  $primerapellido=(isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : "");
  $segundoapellido=(isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : "");

  $foto=(isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
  $cv=(isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");

  $idpuesto=(isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
  $fechadeingreso=(isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "");

  $sentencia=$conexion->prepare("INSERT INTO tbl_empleados(id,primernombre,segundonombre,primerapellido,segundoapellido,foto,cv,idpuesto,fechadeingreso) 
  VALUES (null, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechadeingreso)");
  
  $sentencia->bindParam(":primernombre", $primernombre);
  $sentencia->bindParam(":segundonombre", $segundonombre);
  $sentencia->bindParam(":primerapellido", $primerapellido);
  $sentencia->bindParam(":segundoapellido", $segundoapellido);

  /* ------ nombre de la imagen ------- */
  $fecha_foto = new DateTime();
  $nombreArchivo_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
  $tmp_foto = $_FILES['foto']['tmp_name'];
  if($tmp_foto != ""){
    move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
  }
  $sentencia->bindParam(":foto", $nombreArchivo_foto);

  /* ------ nombre del pdf ------ */
  $fecha_cv = new DateTime();
  $nombreArchivo_cv = ($cv != '') ? $fecha_cv->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
  $tmp_cv = $_FILES['cv']['tmp_name'];
  if($tmp_cv != ""){
    move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
  }
  $sentencia->bindParam(":cv", $nombreArchivo_cv);

  $sentencia->bindParam(":idpuesto", $idpuesto);
  $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
  
  $sentencia->execute();

  $mensaje='New Register Created..';
    header("Location: index.php?mensaje=" . $mensaje);

}

$sentencia=$conexion->prepare("SELECT * FROM tbl_puestos; ");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>


    <div class="card">
        <div class="card-header">
            Employ Info
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                  <label for="primernombre" class="form-label">First Name</label>
                  <input type="text"
                    class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="First Name">
                </div>

                <div class="mb-3">
                  <label for="segundonombre" class="form-label">Second Name</label>
                  <input type="text"
                    class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Second Name">
                </div>
 
                <div class="mb-3">
                  <label for="primerapellido" class="form-label">Last Name</label>
                  <input type="text"
                    class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Last Name">
                </div>

                <div class="mb-3">
                  <label for="segundoapellido" class="form-label">2nd Last Name</label>
                  <input type="text"
                    class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="2nd Last Name">
                </div>

                <div class="mb-3">
                  <label for="foto" class="form-label">Picture: </label>
                  <input type="file"
                    class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Picture: ">
                </div>

                <div class="mb-3">
                  <label for="cv" class="form-label">Resume(.pdf):</label>
                  <input type="file"
                    class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="Resume:">
                </div>

                <div class="mb-3">
                    <label for="idpuesto" class="form-label">Position: </label>
                    <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                      <?php foreach($lista_tbl_puestos as $registro): ?>
                        <option value="<?php echo $registro['id']; ?>" selected><?php echo $registro['nombredelpuesto']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                  <label for="fechadeingreso" class="form-label">Date Board</label>
                  <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Date Board">
                </div>

                <button type="submit" class="btn btn-success">Add</button>
                <a name="" id="" class="btn btn-dark" href="/secciones/empleados/" role="button">Cancel</a>

            </form>
        </div>
        <div class="card-footer text-muted"><br></div>
    </div>




<?php include("../../templates/footer.php"); ?>