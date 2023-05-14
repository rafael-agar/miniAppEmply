<?php 

include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
    $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto=$registro["nombredelpuesto"];
}

if($_POST){
    //recolectamos los datos del metodo post
    $nombredelpuesto=(isset($_POST["nombredelpuesto"]) ? $_POST["nombredelpuesto"] : "");
    //preparando inserccion de los datos
    $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) VALUES (null,:nombredelpuesto)");
    //asignando los valores que vienen del metodo post(del formulario)
    $sentencia->bindParam(":nombredelpuesto", $nombredelpuesto);
    $sentencia->execute();
    $mensaje='New Register Created..';
    header("Location: index.php?mensaje=" . $mensaje);
}

include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Edit Position Data
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="nombredelpuesto" class="form-label">Position Name</label>
              <input type="text"
                class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Name Position" >
            </div>

            <button type="submit" class="btn btn-success">Add</button>
            <a name="" id="" class="btn btn-dark" href="/secciones/puestos" role="button">Cancel</a>

        </form>

    </div>
    <div class="card-footer text-muted"><br></div>
</div>

<?php include("../../templates/footer.php"); ?>