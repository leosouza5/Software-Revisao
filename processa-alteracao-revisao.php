<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_services.php';

    $conexao = new DbService();


    
    $observacao = $_POST['observacao'];
    $cliente = $_POST['cliente'];
    $carro = $_POST['carro'];
    $data = $_POST['data'];

    $revisaoOriginal = $conexao->recuperar("*", "vw_revisao", "id_revisao =" . $_GET['regi'], "");

   #print_r($revisaoOriginal);

    #print_r($_POST);

    if ($revisaoOriginal && ($revisaoOriginal[0]['observacao'] != $observacao || $revisaoOriginal[0]['idcliente'] != $cliente || $revisaoOriginal[0]['idcarro'] != $carro || $revisaoOriginal[0]['data'] != $data)) {
        $atualizacao = $conexao->atualizar("revisoes", "observacao='$observacao', cliente=$cliente, carro='$carro', data='$data'", "id_revisao =" . $_GET['regi']);
        if ($atualizacao) {
            
            header("Location: revisao-acao.php?regi=" . $_GET['regi'] . "&status=ok");
        } else {
            header("Location: revisao-acao.php?regi=" . $_GET['regi'] . "&status=falha");
        }
    } else {
        header("Location: revisao-acao.php?regi=" . $_GET['regi'] . "&status=nada");
    }
}




?>