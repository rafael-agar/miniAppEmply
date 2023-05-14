<?php 

include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
    $sentencia = $conexion->prepare("DELETE FROM tbl_puestos WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje='Your file has been deleted.';
    header("Location: index.php?mensaje=" . $mensaje);
}
//fetchinf data
$sentencia=$conexion->prepare("SELECT * FROM tbl_puestos; ");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
$ruta = '/secciones/puestos/index.php?txtID=';

include("../../templates/header.php"); 
?>


<h3 class="m-3 text-center">Position</h3>

<div class="card">
    <div class="card-header">
    <a name="" id="" class="btn btn-primary" href="/secciones/puestos/crear.php" role="button">Add Position</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Position Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_puestos as $registro): ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id']; ?></td>
                        <td><?php echo $registro['nombredelpuesto']; ?></td>
                        <td>
                            <a name="" id="" 
                            class="btn btn-primary" 
                            href="/secciones/puestos/editar.php?txtID=<?php echo $registro['id']; ?>" 
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