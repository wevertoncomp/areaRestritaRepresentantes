<?
session_start();
if(!isset($_SESSION['login_session']) AND !isset($_SESSION['senha_session'])){
	header("location: index.php");
	exit;
}
?>

<?php 

$login = $_SESSION['login_session'];
$senha = $_SESSION['senha_session'];
$idVideo = $_GET['id'];

$sql2 = mysql_query("SELECT * FROM st_video V WHERE V.idVideo = $idVideo");

while ($array = mysql_fetch_array($sql2)){
	$numero = $array['numero'];
	$titulo = $array['titulo'];
	$descricao = $array['descricao'];
	$arquivo = $array['arquivo'];
	$data = $array['ts'];
}


?>
        
        <h1 class="sub-header">Vídeo nº <?php echo $numero;?></h1>
<div class="table-responsive">
<h3 class="sub-header"><?php echo $titulo;?></h3>
<h5 class="sub-header"><?php echo $descricao;?></h5>

	
<?php 

echo "<iframe width='640' height='480' src='$arquivo' frameborder='0' allowfullscreen></iframe>";

?>

          </div>