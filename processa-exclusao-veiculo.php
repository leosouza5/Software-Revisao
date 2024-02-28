<?php
require('db_services.php');

// Verifica se o ID do carro a ser excluído foi passado via POST
if(isset($_POST['id_carro'])) {
    
    $id_carro = $_POST['id_carro'];

    // Instancia a classe de serviço do banco de dados
    $conexao = new DbService();

    // Executa a função para excluir o carro do banco de dados
    $exclusao = $conexao->remover('carros', 'id_carro = ' . $id_carro);

    // Verifica se a exclusão foi bem-sucedida
    if($exclusao) {
        
        header("Location: carros.php");
        exit();
    } else {

        header("Location: carros.php");
        exit();
    }
} else {
    header("Location: carros.php");
    exit();
}
?>
