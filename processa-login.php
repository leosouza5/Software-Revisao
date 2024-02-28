<?php 


if(isset($_POST['login']) && isset($_POST['senha'])){
	$login = trim($_POST['login']);
	$senha = md5(trim($_POST['senha']));

	require('db_services.php');

	$conexao = new DbService();
	$resultados = $conexao->recuperar("*","usuarios","login = '$login' AND senha= '$senha'","");



	print_r($resultados);

	if($resultados){
		$_SESSION['login'] = $login;
        $_SESSION['senha'] = $senha;
        header('location: index.php');
    } else {
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location: login.php');
	}

}else{
    header('location: login.php');

}
?>