<?
session_start();
if(!isset($_SESSION['login_session']) AND !isset($_SESSION['senha_session'])){
	header("location: index.php");
	exit;
}

$login = $_SESSION ['login_session'];
$senha = $_SESSION ['senha_session'];



?>

<h1 class="sub-header">Ajuda</h1>
<div class="table-responsive">
	<h3 class="sub-header">Em breve</h3>
</div>