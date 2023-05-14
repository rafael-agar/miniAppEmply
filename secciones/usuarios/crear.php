<?php 

include("../../bd.php");

if($_POST){
  // print_r($POST);

  //recolectamos los datos del metodo post
  $usuario=(isset($_POST["usuario"]) ? $_POST["usuario"] : "");
  $password=(isset($_POST["password"]) ? $_POST["password"] : "");
  $email=(isset($_POST["email"]) ? $_POST["email"] : "");
  //preparando inserccion de los datos
  $sentencia=$conexion->prepare("INSERT INTO tbl_usuarios (id,usuario,password,email)
  VALUES(null,:usuario,:password,:email)");
  //asigna valores a los nombre en las :variables 
  $sentencia->bindParam(":usuario", $usuario);
  $sentencia->bindParam(":password", $password);
  $sentencia->bindParam(":email", $email);
  $sentencia->execute();

  $mensaje='New Register Created..';
  header("Location: index.php?mensaje=" . $mensaje);

}

include("../../templates/header.php"); 

?>

<div class="card">
    <div class="card-header">
        User Info
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="usuario" class="form-label">User Name</label>
              <input type="text"
                class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="User Name">
            </div>

            <div class="mb-3">
              <label for="pasword" class="form-label">Password</label>
              <input type="password"
                class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="type password">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email"
                class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="type your email">
            </div>

            <button type="submit" class="btn btn-success">Add</button>
            <a name="" id="" class="btn btn-dark" href="/secciones/usuarios" role="button">Cancel</a>

        </form>

    </div>
    <div class="card-footer text-muted"><br></div>
</div>

<?php include("../../templates/footer.php"); ?>