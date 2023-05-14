<?php 

include("../../bd.php");

//recepcion de valores
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;

    // buscar archivos para borrar
    $sentencia=$conexion->prepare("SELECT foto,cv FROM tbl_empleados WHERE id = :id");
    $sentencia->bindParam(":id", $txtID); 
    $sentencia->execute();
    $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
    // print_r($registro_recuperado);

    if(isset($registro_recuperado['foto']) && $registro_recuperado['foto'] != ""){
        if(file_exists("./" .$registro_recuperado['foto'])){
            unlink("./" . $registro_recuperado['foto']);
        }
    }

    if(isset($registro_recuperado['cv']) && $registro_recuperado['cv'] != ""){
        if(file_exists("./" .$registro_recuperado['cv'])){
            unlink("./" . $registro_recuperado['cv']);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $mensaje='Your file has been deleted.';
    header("Location: index.php?mensaje=" . $mensaje);
}

//fetchinf data
$sentencia=$conexion->prepare("SELECT *,
    (SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto 
    FROM tbl_empleados; ");
$sentencia->execute();
$lista_tbl_empleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);
$ruta = '/secciones/empleados/index.php?txtID=';

include("../../templates/header.php"); 

?>


<h3 class="m-3 text-center">Employ List</h3>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="/secciones/empleados/crear.php" role="button">Add register</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Names and  Last name</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Position</th>
                        <th scope="col">Date board</th>
                        <th scope="col">Acctions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($lista_tbl_empleados as $registro): ?>
                    <tr class="">
                        <td><?php echo $registro['id']; ?></td>
                        <td scope="row">
                            <?php echo $registro['primernombre']; ?> 
                            <?php echo $registro['segundonombre']; ?> 
                            <?php echo $registro['primerapellido']; ?> 
                            <?php echo $registro['segundoapellido']; ?> 
                        </td>
                        <td>
                            <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                        </td>
                        <td>
                            <a href="<?php echo $registro['cv']; ?>">
                            <?php echo $registro['cv']; ?>
                            </a>
                        </td>
                        <td><?php echo $registro['puesto']; ?></td>
                        <td><?php echo $registro['fechadeingreso']; ?></td>
                        <td>
                            <a name="" id="" class="btn btn-primary" href="/secciones/empleados/carta_recomendacion.php?txtID=<?php echo $registro['id']; ?>" role="button" target="_blank">Letter</a> 
                            <a name="" id="" 
                            class="btn btn-info" 
                            href="/secciones/empleados/editar.php?txtID=<?php echo $registro['id']; ?>" 
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
</div>

<?php include("../../templates/footer.php"); ?>