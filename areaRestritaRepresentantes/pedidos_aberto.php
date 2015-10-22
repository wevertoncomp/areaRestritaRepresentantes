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

//echo $login, $senha;

$sql = mysql_query("SELECT U.nome AS nome, U.idUsuario AS idUsuario, U.codigoSistema AS codigoSistema, U.acessos AS acessos, U.tipoUsuario AS tipoUsuario 
					FROM st_usuarios U WHERE U.login = '$login' AND U.senha = '".md5($senha)."' AND (U.nivel = 3 OR U.nivel = 1) AND U.liberado = 1");

/*while($array = mysql_fetch_array($sql))
{
	$nome =  $array['nome'];
}*/

$nome = mysql_result($sql, 0, 'nome');
$idUsuario = mysql_result($sql, 0, 'idUsuario');
$codigoSistema = mysql_result($sql, 0, 'codigoSistema');
$tipoUsuario = mysql_result($sql, 0, 'tipoUsuario');



if ($tipoUsuario == "R") {
	$tipo = "Representante";
} else if ($tipoUsuario == "I"){
	$tipo = "Usuário Interno";
} else if ($tipoUsuario == "S"){
	$tipo = "Supervisor";
}

//$nome = $sql["nome"];

//$nome = $sql["nome"];

?>
        
        <h1 class="sub-header">Pedidos em aberto</h1>
<div class="table-responsive">
	
<?php 
$numero_pedidos = 0;
if ($tipoUsuario == "R") {
$sql2 = mysql_query("	SELECT P.idPedido AS idPedido, P.cliente AS cliente, P.razaoSocial AS razaoSocial,
						P.evento AS evento, DATE_FORMAT(P.dataEntrada , '%d/%c/%Y') AS dataEntrada, 
						DATE_FORMAT(P.dataPrevista , '%d/%c/%Y') AS dataPrevista,
						DATE_FORMAT(P.dataSaida , '%d/%c/%Y') AS dataSaida, P.idRepresentante AS idRepresentante,
						P.filial AS filial
						FROM st_pedidos P WHERE P.idRepresentante = '$codigoSistema' AND P.estado = 1
						AND (P.evento = 'Pedido em fábrica sendo produzido.' OR P.evento = 'Orçamento em análise.'
						OR P.evento = 'Orçamento aprovado.')
						GROUP BY P.idPedido
						ORDER BY P.evento");
} else if ($tipoUsuario == "S") {
$sql = mysql_query("SELECT U.regiao AS regiao FROM st_usuarios U WHERE U.codigoSistema = $codigoSistema");
$regiao = mysql_result($sql, 0, 'regiao');
echo "<h4 class='sub-header'>Região: $regiao</h4>";

$sql2 = mysql_query("	SELECT P.idPedido AS idPedido, P.cliente AS cliente, P.razaoSocial AS razaoSocial,
						P.evento AS evento, DATE_FORMAT(P.dataEntrada , '%d/%c/%Y') AS dataEntrada,
						DATE_FORMAT(P.dataPrevista , '%d/%c/%Y') AS dataPrevista,
						DATE_FORMAT(P.dataSaida , '%d/%c/%Y') AS dataSaida, P.idRepresentante AS idRepresentante,
						P.filial AS filial
						FROM st_pedidos P
            			INNER JOIN st_usuarios U ON P.idRepresentante = U.codigoSistema
						WHERE P.estado = 1 AND (P.evento = 'Pedido em fábrica sendo produzido.' OR P.evento = 'Orçamento em análise.'
						OR P.evento = 'Orçamento aprovado.') AND U.regiao = '$regiao'
						GROUP BY P.idPedido
						ORDER BY U.codigoSistema, P.evento");
} else if ($tipoUsuario == "I") {
echo "<h4 class='sub-header'>Regiões: A e B</h4>";

$sql2 = mysql_query("	SELECT P.idPedido AS idPedido, P.cliente AS cliente, P.razaoSocial AS razaoSocial,
						P.evento AS evento, DATE_FORMAT(P.dataEntrada , '%d/%c/%Y') AS dataEntrada,
						DATE_FORMAT(P.dataPrevista , '%d/%c/%Y') AS dataPrevista,
						DATE_FORMAT(P.dataSaida , '%d/%c/%Y') AS dataSaida, P.idRepresentante AS idRepresentante,
						P.filial AS filial
						FROM st_pedidos P
            			INNER JOIN st_usuarios U ON P.idRepresentante = U.codigoSistema
						WHERE P.estado = 1 AND (P.evento = 'Pedido em fábrica sendo produzido.' OR P.evento = 'Orçamento em análise.'
						OR P.evento = 'Orçamento aprovado.')
						GROUP BY P.idPedido
						ORDER BY U.codigoSistema, P.evento");
}

$numero_pedidos = mysql_num_rows($sql2); ?>

<h3 class="sub-header">Em orçamento ou em fábrica - <?php echo "$numero_pedidos pedidos";?><small> O status do pedido é atualizado às 09:00, 13:00 e 19:00 horas</small></h3>
<table class="table table-striped">
<tr><th>Pedido</th><th>Cliente</th><th>Razão Social</th><th>Evento</th><th>Entrada</th><th>Previsão</th><th>Saída</th><th>Representante</th><th>Empresa</th></tr>

<?php
while ($array = mysql_fetch_array($sql2)){
$idPedido = $array['idPedido'];
$cliente = $array['cliente'];
$razaoSocial = $array['razaoSocial'];
$evento = $array['evento'];
$dataEntrada = $array['dataEntrada'];
$dataPrevista = $array['dataPrevista'];
$dataSaida = $array['dataSaida'];
$idRepresentante = $array['idRepresentante'];
$filial = $array['filial'];

if ($filial == '0201') {
	$filial = "Luxparts";
}else if ($filial = '0101') {
	$filial = 'Pradolux';
}

echo "<tr><td>$idPedido</td><td>$cliente</td><td>$razaoSocial</td><td>$evento</td>
	<td>$dataEntrada</td><td>$dataPrevista</td><td>$dataSaida</td><td>$idRepresentante</td><td>$filial</td></tr>";

}

/*while($array = mysql_fetch_array($sql))
 {
$nome =  $array['nome'];
}*/

?>


            </table>
          </div>