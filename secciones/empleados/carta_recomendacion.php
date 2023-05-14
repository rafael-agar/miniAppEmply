<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){

    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID'] : "" ;
    $sentencia = $conexion->prepare("SELECT *,(SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto  FROM tbl_empleados WHERE id = :id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    // print_r($registro);

    $primernombre=$registro["primernombre"];
    $segundonombre=$registro["segundonombre"];
    $primerapellido=$registro["primerapellido"];
    $segundoapellido=$registro["segundoapellido"];

    $nombreCompleto = $primernombre . " " . $primerapellido;
    
    $foto=$registro["foto"];
    $cv=$registro["cv"];

    $idpuesto=$registro["idpuesto"];
    $puesto=$registro["puesto"];
    $fechadeingreso=$registro["fechadeingreso"];
    $date=time();
    $formatDate=date('Y-m-d',$date);

}
//aqui empieza a recolectar
ob_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Letter of Reference - Web Developer</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: #333;
      }
      h1, h2, h3, h4, h5, h6 {
        font-weight: bold;
        margin: 0;
        color: #333;
      }
      p {
        margin: 0 0 10px;
        color: #555;
      }
      strong {
        font-weight: bold;
      }
      .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
      }
      .header {
        text-align: center;
        margin-bottom: 30px;
      }
      .header h1 {
        font-size: 32px;
        color: #333;
        margin-bottom: 10px;
      }
      .header p {
        font-size: 20px;
        color: #666;
        margin: 0;
      }
      .section {
        margin-bottom: 30px;
      }
      .section-title {
        font-size: 24px;
        margin-bottom: 20px;
      }
      .subsection {
        margin-bottom: 20px;
      }
      .subsection-title {
        font-size: 20px;
        margin-bottom: 10px;
      }
      .subsection p {
        margin-bottom: 0;
      }
      .footer {
        text-align: right;
        margin-top: 30px;
      }
      .footer p {
        margin: 0;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <h1>Letter of Reference</h1>
        <p><?php echo $puesto; ?> Position</p>
      </div>
      <div class="section">
        <h2 class="section-title">Introduction</h2>
        <p><strong>To Whom It May Concern:</strong></p>
        <p>
          I am writing this letter of reference for <strong><?php echo $nombreCompleto; ?></strong>, who worked as a web developer with our company, <strong>[Company Name]</strong>, from <strong><?php echo $fechadeingreso; ?></strong> to <strong><?php echo $formatDate; ?></strong>. As their supervisor, I can confidently say that <strong><?php echo $puesto; ?></strong> was an exceptional employee who consistently exceeded expectations.
        </p>
      </div>
      <div class="section">
        <h2 class="section-title">Technical Skills</h2>
        <div class="subsection">
          <h3 class="subsection-title">Web Development Technologies</h3>
          <p><strong>Languages:</strong> HTML, CSS, JavaScript, PHP</p>
          <p><strong>Frameworks/Libraries:</strong> React, Angular, Vue.js, Bootstrap, jQuery</p>
        </div>
        <div class="subsection">
          <h3 class="subsection-title">Content Management Systems (CMS)</h3>
          <p><strong>Platforms:</strong> WordPress
          </div>
      </div>
      <div class="section">
        <h2 class="section-title">Work Performance</h2>
        <p>
          <strong><?php echo $nombreCompleto; ?></strong> consistently demonstrated exceptional technical skills in web development throughout their employment. They were responsible for developing and maintaining multiple websites for our company, and always delivered high-quality work that exceeded expectations. They also provided valuable technical advice to the team and showed great initiative in identifying and addressing potential issues before they became problems.
        </p>
        <p>
          <strong>Mr(s). <?php echo $primerapellido; ?></strong> was an excellent team player and communicated effectively with team members and stakeholders. They consistently met deadlines and were able to handle multiple projects simultaneously, demonstrating excellent time management skills.
        </p>
      </div>
      <div class="section">
        <h2 class="section-title">Conclusion</h2>
        <p>
          In summary, <strong><?php echo $puesto; ?></strong> is an exceptional web developer with strong technical skills, excellent work ethic, and outstanding communication skills. They would be a valuable addition to any team and I strongly recommend them for any web development position they may be seeking.
        </p>
      </div>
      <div class="footer">
        <p>Sincerely,</p>
        <p><strong>[Your Name]</strong></p>
        <p><em>[Your Title]</em></p>
      </div>
    </div>
  </body>
</html>

<?php
$HTML = ob_get_clean(); //obtenemos el HTML

require("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
//opciones de conversion, activacion de opciones
$opciones = $dompdf->getOptions();
//poner las opciones para q se asignen parametros
$opciones->set(array("isRemoteEnabled"=>true));
//activar options, se asignan a
$dompdf->setOptions($opciones);
//pasarle un doc html
$dompdf->loadHTML($HTML);
//se recolecta el HTML
$dompdf->setPaper('letter');
$dompdf->render();
//mostrar el archivo
$dompdf->stream("archivo.pdf", array("Attachment"=>false));

?>