<?php

session_start();

if($_POST){
    include("./bd.php");

    $sentencia=$conexion->prepare("SELECT *,count(*) as n_usuarios FROM tbl_usuarios WHERE usuario=:usuario AND password=:password ");
    $usuario=$_POST['usuario'];
    $password=$_POST['password'];

    $sentencia->bindParam(":usuario",$usuario);
    $sentencia->bindParam(":password",$password);

    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);
    
    if($registro['n_usuarios']==1){
        $_SESSION['usuario']=$registro['usuario'];
        //se crea en el array
        $_SESSION['logueado']=true;
        header("Location:index.php");
    } else {
        $mensaje = "Error, user or password failed.";
    }
}

?>




<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
<?php if(isset($_GET['msn'])): ?>
    <script>
        Swal.fire({icon:"success", title: "<?php echo $_GET['msn']; ?>"});
    </script>
<?php endif; ?>
  <main class="container">

    <div class="row mt-5" style="display:flex; justify-content:center;">
    <h3 class="text-center mb-5">Welcome to the System!</h3>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">

                    <?php if(isset($mensaje)): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $mensaje; ?></strong>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <div class="mb-3">
                          <label for="usuario" class="form-label">User: </label>
                          <input type="text"
                            class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Username">
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password: </label>
                          <input type="password"
                            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="******">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <br>
                </div>
            </div>
        </div>

    </div>

  </main>



  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>