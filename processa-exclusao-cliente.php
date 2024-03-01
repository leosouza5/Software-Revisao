<?php
require('db_services.php');

if(isset($_GET['regi'])) {
    
    $id_cliente = $_GET['regi'];



    // Instancia a classe de serviço do banco de dados
    $conexao = new DbService();

    // Executa a função para excluir o carro do banco de dados
    $exclusao = $conexao->remover('clientes', "id = '$id_cliente'");

    if($exclusao) {
        header("Location: cliente-acao.php?regi=" . $_GET['regi'] . "&status=ok");
        exit();
    } else {
  
        header("Location: cliente-acao.php?regi=" . $_GET['regi'] . "&status=falha");
        exit();
    }
} else {
    header("Location: cliente-acao.php?status=nada");
    exit();
}
?>
