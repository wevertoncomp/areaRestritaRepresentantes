<?
session_start ();
if (! isset ( $_SESSION ['login_session'] ) and ! isset ( $_SESSION ['senha_session'] )) {
	header ( "location: index.php" );
	exit ();
}
?>

<?php

$login = $_SESSION ['login_session'];
$senha = $_SESSION ['senha_session'];

?>

<h1 class="sub-header">Log de acesso</h1>
<div class="table-responsive">
	<h3 class="sub-header">Acessos dos usuários</h3>
	<table class="table table-striped">
		<tr>
			<th>Nome</th>
			<th>Tipo</th>
			<th>Acessos</th>
			<th>Último acesso</th>
		</tr>
	
<?php

/* Quantidade de acessos e último acessso */
$sql2 = mysql_query ( "	SELECT U.idUsuario AS idUsuario, U.nome AS nome, U.tipoUsuario AS tipoUsuario, U.acessos AS acessos,
						DATE_FORMAT(U.ts , '%d/%c/%Y %h:%m:%s') AS ts 
						FROM st_usuarios U WHERE U.liberado = 1 ORDER BY U.acessos DESC" );

while ( $array = mysql_fetch_array ( $sql2 ) ) {
	$idUsuario = $array ['idUsuario'];
	$nome = $array ['nome'];
	$tipoUsuario = $array ['tipoUsuario'];
	$acessos = $array ['acessos'];
	$ultimoAcesso = $array['ts'];
	
	/*$ts = null;
	$sql3 = mysql_query ( "SELECT DATE_FORMAT(UL.ts , '%d/%c/%Y %h:%m:%s') AS ts FROM st_usuarioslog UL WHERE UL.idUsuario = $idUsuario ORDER BY UL.ts DESC LIMIT 1" );
	while ( $array2 = mysql_fetch_array ( $sql3 ) ) {
		$ts = $array2 ['ts'];
	}*/
	
	echo "<tr><td>$nome</td><td>$tipoUsuario</td><td>$acessos</td><td>$ultimoAcesso</td></tr>";
}
/* Páginas mais visitadas */
// echo PHP_OS;
?>
</table>

<p>I = Usuário Interno | R = Representante | S = Supervisor </p>

	<h3 class="sub-header">Páginas mais acessadas</h3>
	<table class="table table-striped">
		<tr>
			<th>Nome</th>
			<th>Acessos</th>
		</tr>
	
<?php

/* Quantidade de acessos e último acessso */
$sql2 = mysql_query ( "SELECT COUNT(*) AS acessos, endereco FROM st_usuarioslog LU GROUP BY endereco ORDER BY COUNT(*) DESC" );

while ( $array = mysql_fetch_array ( $sql2 ) ) {
	$endereco = $array ['endereco'];
	$acessos = $array ['acessos'];
	
	echo "<tr><td>$endereco</td><td>$acessos</td></tr>";
}
?>
</table>

</div>