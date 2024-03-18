<?php
require('db_services.php');

if (isset($_GET['regi'])) {
    $conexao = new DbService();

    switch ($_GET['origem']) {

        case 'cliente':

            $id_cliente = $_GET['regi'];

            // Instancia a classe de serviço do banco de dados


            //Verificar se o cliente tem carros cadastrados


            $temCarro = $conexao->recuperar("COUNT(*)", "carros", "cliente = '$id_cliente'", "");

            //Verifica se o cliente tem revisoes
            $temRevisao = $conexao->recuperar("COUNT(*)", "revisoes", "cliente = '$id_cliente'", "");


            if ($temCarro[0]['count'] > 0) {
                $excluirCarros = $conexao->remover("carros", "cliente = '$id_cliente'");
                echo "Deletei os carros... ";
            }

            if ($temRevisao[0]['count'] > 0) {
                $excluirRevisoes = $conexao->remover("revisoes", "cliente = '$id_cliente'");
                echo 'Deletei as revisões...';
            }



            $exclusao = $conexao->remover('clientes', "id = '$id_cliente'");


            if ($exclusao) {
                echo "Exclusão do cliente realizada com sucesso!!";
                break;
            } else {

                echo "Deu errado";
                break;
            }

        case 'veiculo':
            $id_veiculo = $_GET['regi'];





            $temRevisao = $conexao->recuperar("COUNT(*)", "revisoes", "carro = '$id_veiculo'", "");
            if ($temRevisao[0]['count'] > 0) {

                $excluirRevisoes  = $conexao->remover("revisoes", "carro = '$id_veiculo'");
                if ($excluirRevisoes) {
                    echo "Removi a revisão...";
                    print_r($excluirRevisoes);
                } else {
                    echo "Houve um erro ao remover a revisão";
                    break;
                }
            } else {
                echo "Nao tem nenhum revisao para esse veiculo...";
            }

            $exclusao = $conexao->remover("carros", "id_carro = '$id_veiculo'");

            if ($exclusao) {
                echo "Removi o veiculo...";
            } else {
                echo "Houve um erro ao remover veiculo";
                break;
            }

            break;

        case 'revisao':
            $id_revisao = $_GET['regi'];
            $excluirRevisoes  = $conexao->remover("revisoes", "id_revisao = '$id_revisao'");
            if ($excluirRevisoes) {
                echo "Removi a revisão...";
                break;
            } else {
                echo "Houve um erro ao remover a revisão";
                break;
            }
    }
} else {

    exit();
}
