<?php
if(isset($_POST)){

	print_r($_POST);
	require('db_services.php');

	$conexao = new DbService();

	$resultado = $conexao->inserir("INSERT INTO leonardo.carros (nome, marca, placa, cliente) VALUES ('" . $_POST['nome'] . "','" . $_POST['marca'] . "','" . $_POST['placa'] . "','" . $_POST['cliente'] . "')");


	if ($resultado) {
        header('location: carros.php?status=ok');
    } else {
        header('location: carros.php?status=falha');
    }

}
?>

