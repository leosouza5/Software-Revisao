<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_services.php';

    $conexao = new DbService();


    
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $placa = $_POST['placa'];
    $cliente = $_POST['cliente'];

    $carroOriginal = $conexao->recuperar("*", "vw_carros", "id_carro =" . $_GET['regi'], "");

   #print_r($carroOriginal);

    #print_r($_POST);

    if ($carroOriginal && ($carroOriginal[0]['nome'] != $nome || $carroOriginal[0]['idmarca'] != $marca || $carroOriginal[0]['placa'] != $placa || $carroOriginal[0]['idcliente'] != $cliente)) {
        $atualizacao = $conexao->atualizar("carros", "nome='$nome', marca=$marca, placa='$placa', cliente='$cliente'", "id_carro =" . $_GET['regi']);
        if ($atualizacao) {
            
            header("Location: carros-acao.php?regi=" . $_GET['regi'] . "&status=ok");
            
        } else {
            header("Location: carros-acao.php?regi=" . $_GET['regi'] . "&status=falha");
        }
    } else {
        header("Location: carros-acao.php?regi=" . $_GET['regi'] . "&status=nada");
        close();
    }
}

?>
