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
        
        <h1 class="sub-header">Fichas Técnicas</h1>
<div class="table-responsive">
<h3 class="sub-header">Clique no ícone para visualizar</h3>
	<table class="table table-striped">
	<tr><th>Número</th><th>Título</th><th>Visualizar</th><th>Download</th></tr>
	
<?php 

$sql2 = mysql_query("SELECT * FROM st_fichatecnica FT");

while ($array = mysql_fetch_array($sql2)){
$idFichaTecnica = $array['idFichaTecnica'];
$numero = $array['numero'];
$titulo = $array['titulo'];
$descricao = $array['descricao'];
$arquivo = $array['arquivo'];
$data = $array['ts'];

echo "<tr><td>$numero</td><td>$titulo</td>
<td><a href='arquivos/fichas_tecnicas/$arquivo.pdf' target='_blank'><img src='images/visualizar.png'></a></td>
<td><a href='arquivos/fichas_tecnicas/$arquivo.zip' target='_blank'><img src='images/download.png'></a></td></tr>";

}

/*while($array = mysql_fetch_array($sql))
 {
$nome =  $array['nome'];
}*/

?>


            </table>
          </div>