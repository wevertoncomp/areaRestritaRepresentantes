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


?>
        
        <h1 class="sub-header">Vídeos</h1>
<div class="table-responsive">
<h3 class="sub-header">Clique no ícone visualizar para assistir o vídeo</h3>
	<table class="table table-striped">
	<tr><th>Número</th><th>Título</th><th>Visualizar</th></tr>
	
<?php 

$sql2 = mysql_query("SELECT * FROM st_video V");

while ($array = mysql_fetch_array($sql2)){
$idVideo = $array['idVideo'];
$numero = $array['numero'];
$titulo = $array['titulo'];
$descricao = $array['descricao'];
$arquivo = $array['arquivo'];
$data = $array['ts'];

echo "<tr><td>$numero</td><td>$titulo</td>
<td><a href='?pg=video&id=$idVideo'><img src='images/visualizar.png'></a></td></tr>";

}

/*while($array = mysql_fetch_array($sql))
 {
$nome =  $array['nome'];
}*/

?>


            </table>
          </div>