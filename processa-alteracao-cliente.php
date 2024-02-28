<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_services.php';

    $conexao = new DbService();

   $id = $_GET['regi'];
    
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $telefone = $_POST['telefone'];

    $clienteOriginal = $conexao->recuperar("*", "clientes", "id ='$id'"  , "");



    if ($clienteOriginal && ($clienteOriginal[0]['nome_cliente'] != $nome || $clienteOriginal[0]['genero'] != $genero || $clienteOriginal[0]['id'] != $cpf_cnpj || $clienteOriginal[0]['telefone'] != $telefone)) {


        $atualizacao = $conexao->atualizar("clientes", "nome_cliente='$nome', genero='$genero', id='$cpf_cnpj', telefone='$telefone'", "id ='$id'");
        if ($atualizacao) {
            header("Location: cliente-acao.php?regi=" . $_GET['regi'] . "&status=ok");
        } else {
            echo "n deu certo atualizacao";
            header("Location: cliente-acao.php?regi=" . $_GET['regi'] . "&status=falha");
        }
    } else {
        echo "n deu";
        header("Location: cliente-acao.php?regi=" . $_GET['regi'] . "&status=nada");
    }
}

?>

