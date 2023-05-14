<?php 

include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
    $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    $primernombre=$registro["primernombre"];
    $segundonombre=$registro["segundonombre"];
    $primerapellido=$registro["primerapellido"];
    $segundoapellido=$registro["segundoapellido"];
    
    $foto=$registro["foto"];
    $cv=$registro["cv"];

    $idpuesto=$registro["idpuesto"];
    $fechadeingreso=$registro["fechadeingreso"];

    //lista de puestos
    $sentencia=$conexion->prepare("SELECT * FROM tbl_puestos; ");
    $sentencia->execute();
    $lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);  

}

//update
if($_POST){

    $txtID=(isset($_POST['txtID'])) ? $_POST['txtID'] : "" ;
    $primernombre=(isset($_POST["primernombre"]) ? $_POST["primernombre"] : "");
    $segundonombre=(isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : "");
    $primerapellido=(isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : "");
    $segundoapellido=(isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : "");  
    $idpuesto=(isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
    $fechadeingreso=(isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "");
  
    $sentencia=$conexion->prepare("UPDATE tbl_empleados 
    SET
    primernombre=:primernombre,
    segundonombre=:segundonombre,
    primerapellido=:primerapellido,
    segundoapellido=:segundoapellido,

    idpuesto=:idpuesto,
    fechadeingreso=:fechadeingreso 
    WHERE id=:id ");
    
    $sentencia->bindParam(":id", $txtID);
    $sentencia->bindParam(":primernombre", $primernombre);
    $sentencia->bindParam(":segundonombre", $segundonombre);
    $sentencia->bindParam(":primerapellido", $primerapellido);
    $sentencia->bindParam(":segundoapellido", $segundoapellido);  
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    
    $sentencia->execute();

    
     /* ------ Updating foto a parte.... nombre de la imagen ------- */
    $foto=(isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    $fecha_foto = new DateTime();
    $nombreArchivo_foto = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
    $tmp_foto = $_FILES['foto']['tmp_name'];
    //actualizar foto
    if($tmp_foto != ""){
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);

    // buscar archivos para borrar
        $sentencia=$conexion->prepare("SELECT foto FROM tbl_empleados WHERE id = :id");
        $sentencia->bindParam(":id", $txtID); 
        $sentencia->execute();
        $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
        // print_r($registro_recuperado);
        if(isset($registro_recuperado['foto']) && $registro_recuperado['foto'] != ""){
            if(file_exists("./" .$registro_recuperado['foto'])){
                unlink("./" . $registro_recuperado['foto']);
            }
    }
    
        //se actualiza
        $sentencia=$conexion->prepare("UPDATE tbl_empleados SET foto=:foto WHERE id=:id ");
        $sentencia->bindParam(":foto", $nombreArchivo_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    /* ------ Updating cv a parte.... nombre del cv ------- */
    $cv=(isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");
    //cargamos la foto
    $fecha_cv = new DateTime();
    $nombreArchivo_cv = ($cv != '') ? $fecha_cv->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
    $tmp_cv = $_FILES['cv']['tmp_name'];
    if($tmp_cv != ""){
        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);

        // buscar archivos para borrar
        $sentencia=$conexion->prepare("SELECT cv FROM tbl_empleados WHERE id = :id");
        $sentencia->bindParam(":id", $txtID); 
        $sentencia->execute();
        $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);

        if(isset($registro_recuperado['cv']) && $registro_recuperado['cv'] != ""){
            if(file_exists("./" .$registro_recuperado['cv'])){
                unlink("./" . $registro_recuperado['cv']);
            }
        }

        //se actualiza
        $sentencia=$conexion->prepare("UPDATE tbl_empleados SET cv=:cv WHERE id=:id ");
        $sentencia->bindParam(":cv", $nombreArchivo_cv);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }
    $mensaje='Update Completed.';
    header("Location: index.php?mensaje=" . $mensaje);
  
  }


include("../../templates/header.php"); ?>

<div class="card">
        <div class="card-header">
            Edit Employ Info
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                <label for="txtID" class="form-label">ID</label>
                <input type="text" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" value="<?php echo $txtID; ?>" >
                </div>

                <div class="mb-3">
                  <label for="primernombre" class="form-label">First Name</label>
                  <input type="text"
                    class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="First Name" value="<?php echo $primernombre; ?>">
                </div>

                <div class="mb-3">
                  <label for="segundonombre" class="form-label">Second Name</label>
                  <input type="text"
                    class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Second Name" value="<?php echo $segundonombre; ?>">
                </div>
 
                <div class="mb-3">
                  <label for="primerapellido" class="form-label">Last Name</label>
                  <input type="text"
                    class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Last Name" value="<?php echo $primerapellido; ?>">
                </div>

                <div class="mb-3">
                  <label for="segundoapellido" class="form-label">2nd Last Name</label>
                  <input type="text"
                    class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="2nd Last Name" value="<?php echo $segundoapellido; ?>">
                </div>

                <div class="mb-3">
                  <label for="foto" class="form-label">Picture: </label>
                  <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                  <input type="file"
                    class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Picture: ">
                </div>

                <div class="mb-3">
                  <label for="cv" class="form-label">Resume(.pdf):</label>
                  CV: <a href="<?php echo $cv; ?>" target="_blank"><?php echo $cv; ?> </a>
                  <input type="file"
                    class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="Resume:">
                </div>

                <div class="mb-3">
                    <label for="idpuesto" class="form-label">Position: </label>
                    <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                      <?php foreach($lista_tbl_puestos as $registro): ?>
                        <option 
                            value="<?php echo $registro['id']; ?>" 
                            <?php echo ($idpuesto === $registro['id']) ? "selected" : ""; ?> 
                        >
                            <?php echo $registro['nombredelpuesto']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                  <label for="fechadeingreso" class="form-label">Date Board</label>
                  <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Date Board" value="<?php echo $fechadeingreso; ?>">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a name="" id="" class="btn btn-dark" href="/secciones/empleados/" role="button">Cancel</a>

            </form>
        </div>
        <div class="card-footer text-muted"><br></div>
    </div>

<?php include("../../templates/footer.php"); ?>