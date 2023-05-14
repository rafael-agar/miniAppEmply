<?php
    session_start();
    $url_base = $_SERVER['HTTP_HOST'];
    // var_dump($_SERVER['HTTP_HOST']);

    if(!isset($_SESSION['logueado'])){
        $please="Please, Login.";
        header("Location:/login.php?msn=" . $please);
    } 
?>



<!doctype html>
<html lang="en">

<head>
  <title>App Empleados</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="/" aria-current="page">Home<span class="visually-hidden">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php $url_base; ?>/secciones/empleados/index.php">Employs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php $url_base; ?>/secciones/puestos">Position</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php $url_base; ?>/secciones/usuarios">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php $url_base; ?>/cerrar.php">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- recibimos el mensaje des get, y sale el alert confirmar -->
<?php if(isset($_GET['mensaje'])): ?>
    <script>
        Swal.fire({icon:"success", title: "<?php echo $_GET['mensaje']; ?>"});
    </script>
<?php endif; ?>

  <main class="container mt-5">