<?php
if(isset($_POST)){

	print_r($_POST);



    print_r($_GET);
	require('db_services.php');

	$conexao = new DbService();

	$resultado = $conexao->inserir("INSERT INTO leonardo.carros (nome, marca, placa, cliente) VALUES ('" . $_POST['nome'] . "','" . $_POST['marca'] . "','" . $_POST['placa'] . "','" . $_POST['cliente'] . "')");


	 if (isset($_GET['origem']) && $_GET['origem'] === 'listarCarros') {
        $link = 'listarCarros.php';
    } else {
        $link = 'carros.php';
    }


    

    if($link === 'carros.php') {

        if($resultado){
            header('location: ' . $link . '?status=ok');
        }else {
        header('location: ' . $link . '?status=falha');
        }   

    } else if($link === 'listarCarros.php'){
        
        if($resultado){
            header('location: ' . $link . '?status=ok&regi='. $_POST['cliente']);
        } else {
            header('location: ' . $link . '?status=ok&regi='. $_POST['cliente']);
        }
        
    }


    
    
}
?>

