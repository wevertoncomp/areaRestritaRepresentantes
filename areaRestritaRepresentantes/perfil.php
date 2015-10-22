<?
session_start();
if(!isset($_SESSION['login_session']) AND !isset($_SESSION['senha_session'])){
	header("location: index.php");
	exit;
}
?>

<?php

$login = $_SESSION ['login_session'];
$senha = $_SESSION ['senha_session'];

$sql = mysql_query("SELECT U.nome AS nome, U.idUsuario AS idUsuario, U.codigoSistema AS codigoSistema, U.acessos AS acessos, 
		U.tipoUsuario AS tipoUsuario, U.login AS login, U.email AS email
		FROM st_usuarios U WHERE U.login = '$login' AND U.senha = '$senha' AND (U.nivel = 3 OR U.nivel = 1) AND U.liberado = 1");

/*while($array = mysql_fetch_array($sql))
 {
$nome =  $array['nome'];
}*/

$nome = mysql_result($sql, 0, 'nome');
$login = mysql_result($sql, 0, 'login');
$email = mysql_result($sql, 0, 'email');

?>

<h1 class="sub-header">Perfil</h1>
<div class="table-responsive">
	<h3 class="sub-header">Visualize ou edite o seu perfil</h3>

	<section id="wrapper"> <!--code for form--> <section id="form">
	<form name="login-form" id="smart-login" method="post"
		action="?pg=biografia_edita">
		<fieldset id="smart-login-fields">
			<div class="panel panel-default">
				<div class="panel-heading">Dados Pessoais</div>
  
				<div class="panel-body">
					Nome: <input type="text" class="form-control" id="nome" value = "<?php echo $nome;?>" required="required">
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Dados de acesso</div>
				<div class="panel-body">
					Login: <input type="text" class="form-control" id="login" value = "<?php echo $login;?>" required="required">
					E-mail: <input type="email" class="form-control" id="email" value = "<?php echo $email;?>" required="required">
					Senha atual: <input type="text" class="form-control" id="senha_atual" required="required">
					Nova senha: <input type="text" class="form-control" id="senha_nova" required="required">
					Repetir a nova senha: <input type="text" class="form-control" id="senha_nova2" required="required">
				</div>
			</div>

		</fieldset>

		<fieldset id="smart-login-actions">
			<div class="panel panel-default">
				<div class="panel-body">
					<input type="submit" id="logar" name="logar" value="Salvar Alterações" class="btn btn-primary">
				</div>
			</div>
		</fieldset>
		<br />
	</form>
	</section> </section>
</div>