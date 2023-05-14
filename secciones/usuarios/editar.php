<?php 

include("../../bd.php");

if(isset($_GET['txtID'])){
  $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
  $sentencia = $conexion->prepare("SELECT * FROM tbl_usuarios WHERE id = :id");
  $sentencia->bindParam(":id",$txtID);
  $sentencia->execute();
  $registro=$sentencia->fetch(PDO::FETCH_LAZY);
  $usuario=$registro["usuario"];

}

if($_POST){
  // print_r($POST);

  //recolectamos los datos del metodo post
  $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
  $usuario=(isset($_POST["usuario"]) ? $_POST["usuario"] : "");
  $password=(isset($_POST["password"]) ? $_POST["password"] : "");
  $email=(isset($_POST["email"]) ? $_POST["email"] : "");
  //preparando inserccion de los datos
  $sentencia=$conexion->prepare("UPDATE tbl_usuarios SET usuario = :usuario, password = :password, email = :email WHERE id = :id");
  //asigna valores a los nombre en las :variables 
  $sentencia->bindParam(":id", $txtID);
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->bindParam(":password", $password);
  $sentencia->bindParam(":email", $email);
  $sentencia->execute();

  $mensaje='Update Completed.';
  header("Location: index.php?mensaje=" . $mensaje);
}

include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        Edit User Info
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <!-- recibimos el ID desde _GET -->
            <div class="mb-3">
              <label for="txtID" class="form-label">ID</label>
              <input type="text" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" value="<?php echo $txtID; ?>" >
            </div>

            <div class="mb-3">
              <label for="usuario" class="form-label">User Name</label>
              <input type="text"
                class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="User Name" value="<?php echo $registro['usuario']; ?>">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password"
                class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="type password" value="******">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email"
                class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="type your email" value="<?php echo $registro['email']; ?>">
            </div>

            <button type="submit" class="btn btn-success">Add</button>
            <a name="" id="" class="btn btn-dark" href="/secciones/usuarios" role="button">Cancel</a>

        </form>

    </div>
    <div class="card-footer text-muted"><br></div>
</div>

<?php include("../../templates/footer.php"); ?>