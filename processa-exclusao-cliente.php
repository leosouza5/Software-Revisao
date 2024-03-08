<?php
require('db_services.php');

if(isset($_GET['regi'])) {
    
    $id_cliente = $_GET['regi'];



    // Instancia a classe de serviço do banco de dados
    $conexao = new DbService();

    //Verificar se o cliente tem carros cadastrados

    $temCarro = $conexao->recuperar("COUNT(*)","carros","cliente = '$id_cliente'","");


    //Verifica se o cliente tem revisoes
    $temRevisao = $conexao->recuperar("COUNT(*)","revisoes","cliente = '$id_cliente'","");


    if($temCarro[0]['count'] > 0){
        $excluirCarros = $conexao->remover("carros","cliente = '$id_cliente'");
        echo "Deletei os carros... ";
    }

    if($temRevisao[0]['count'] > 0){
        $excluirRevisoes = $conexao->remover("revisoes","cliente = '$id_cliente'");
        echo 'Deletei as revisões...';
    }



    $exclusao = $conexao->remover('clientes', "id = '$id_cliente'");


    if($exclusao) {
        echo "Exclusão do cliente realizada com sucesso!!";
        exit();
    } else {
  
        echo "OIII";
        exit();
    }

} else {

    exit();
}
?>
