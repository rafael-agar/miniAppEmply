<?php 

include("../../bd.php");

$sentencia=$conexion->prepare("SELECT * FROM tbl_usuarios; ");
$sentencia->execute();
$lista_tbl_usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
    $sentencia = $conexion->prepare("DELETE FROM tbl_usuarios WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje='Your file has been deleted.';
    header("Location: index.php?mensaje=" . $mensaje);
}
$ruta = '/secciones/usuarios/index.php?txtID=';

include("../../templates/header.php"); 

?>

<h3 class="m-3 text-center">Users</h3>

<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="/secciones/usuarios/crear.php" role="button">Add User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Password</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach($lista_tbl_usuarios as $registro): ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['usuario']; ?></td>
                        <td>*******</td>
                        <td><?php echo $registro['email']; ?></td>
                        <td>
                        <a name="" id="" 
                            class="btn btn-primary" 
                            href="/secciones/usuarios/editar.php?txtID=<?php echo $registro['id']; ?>" 
                            role="button">Edit</a>

                            <a name="" id="" 
                            class="btn btn-danger" 
                            href="javascript:borrar('<?php echo $ruta . $registro['id']; ?>')" 
                            role="button">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"><br></div>
</div>

<?php include("../../templates/footer.php"); ?>