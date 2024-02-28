<?php
require('db_services.php');

if(isset($_POST['id_revisao'])) {
    
    $id_revisao = $_POST['id_revisao'];

    // Instancia a classe de serviço do banco de dados
    $conexao = new DbService();

    // Executa a função para excluir o carro do banco de dados
    $exclusao = $conexao->remover('revisoes', 'id_revisao = ' . $id_revisao);

    if($exclusao) {

        header("Location: revisao-acao.php?regi=" . $_GET['regi'] . "&status=ok");
        exit();
    } else {
  
        header("Location: revisao-acao.php?regi=" . $_GET['regi'] . "&status=falha");
        exit();
    }
} else {
    header("Location: revisoes.php");
    exit();
}
?>
