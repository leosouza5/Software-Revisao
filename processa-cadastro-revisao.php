<?php
    require('db_services.php');

    $conexao = new DbService();

    $observacao = $_POST['observacao'];
    $cliente = $_POST['cliente'];
    $carro = $_POST['carro'];
    $data = $_POST['data'];


    $resultado = $conexao->inserir("INSERT INTO leonardo.revisoes (observacao, cliente, carro, data) VALUES ('$observacao','$cliente',$carro,'$data')");


   # echo('oi' . $resultado . 'oi');
    if ($resultado) {
        header('location: revisoes.php?status=ok');
 
    } else {
        header('location: revisoes.php?status=falha');
        exit();
    }

?>
