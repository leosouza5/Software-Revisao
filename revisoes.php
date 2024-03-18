<?php

require('header.php');

require('db_services.php');

if (isset($_GET['acao']) && $_GET['acao'] == 'cadastrar') {
    $listar = 'N';
} else {
    $listar = 'S';
}

$conexao = new DbService();
$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");

$listaCarros = $conexao->recuperar("*", "carros", "", "nome");
$listaRevisoes = $conexao->recuperar("*", "vw_revisao", "", "data");



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/2afc7f22a6.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <title>Cadastro de Revisões</title>
</head>

<body onload="recuperarListaRevisao()" style="background-color: #eee;">



    <?php if ($listar == 'N') {  ?>
        <form action="processa-cadastro-revisao.php" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 86vh;" id="form-cadrevisao">
            <div class="col-md-8 ">
                <h1>Cadastro de Revisão</h1>
                <div class="form-group rounded shadow p-4">
                    <label for="observacao">Observação</label>
                    <span style="display: none;" id="erro-revisao-observacao" class="alert alert-info ">Por favor, informe uma observação valida !</span>
                    <textarea class="form-control" id="observacao" name="observacao" required></textarea>
                </div>
                <div class="form-group rounded shadow p-4">
                    <label for="cliente">Cliente</label>
                    <span style="display: none;" id="erro-revisao-cliente" class="alert alert-info ">Por favor, informe um cliente valido!</span>
                    <select onchange="recuperarCarros(this.value)" class="form-control" id="cliente" name="cliente" required>
                        <option value="">Selecione o cliente</option>
                        <?php foreach ($listaClientes as $cliente) { ?>
                            <option value="<?= $cliente['id'] ?>"><?= $cliente['nome_cliente'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group rounded shadow p-4">
                    <label for="carro">Carro</label>
                    <span style="display: none;" id="erro-revisao-carro" class="alert alert-info ">Por favor, informe um carro válido!</span>
                    <select class="form-control" id="carro" name="carro" required>
                        <option value="">Selecione o carro</option>
                    </select>
                </div>
                <div class="form-group rounded shadow p-4">
                    <label for="data">Data</label>
                    <span style="display: none;" id="erro-revisao-data" class="alert alert-info ">Por favor, informe uma data válida!</span>
                    <input class="form-control" type="date" id="data" name="data" required>
                </div>
            </div>
        </form>
        <div class="row fixed-bottom bg-dark">
            <div class="col-12 text-center py-2">
                <button id="enviar" onclick="validaFormRevisao()" class="btn btn-light" style="font-weight: 500;">Confirmar</button>
            </div>
        </div>
    <?php } ?>



    <?php

    $cont = 1;

    if ($listar == 'S') {

    ?>

        <div style="height: 86vh;" class="row no-gutters overflow-auto">
            <div class="col-12">
                <div class="row no-gutters">
                    <div class="col-4 text-center">
                        <span>
                            <h1 class="m-3 d-inline">Revisao</h1>
                            <a href="revisoes.php?acao=cadastrar" class="btn btn-info d-inline"><i class="fa-solid fa-plus"></i></a>
                        </span>
                    </div>
                    <div class="col-2 text-center align-items-center" id="carregando"></div>
                    <div class="col-6">
                        <div class="input-group my-3">
                            <div class="input-group-prepend" id="button-addon3">
                                <select class="custom-select" id="pes_filtro_parametro">
                                    <option value="cliente">Cliente</option>
                                    <option value="data">Data</option>
                                </select>
                            </div>
                            <input type="text" onkeyup="buscarRevisao()" class="form-control" placeholder="" id="pes_filtro_texto" aria-label="Example text with two button addons" aria-describedby="button-addon3">
                        </div>
                    </div>
                </div>
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Data</th>
                            <th scope="col">Carro</th>
                            <th scope="col">Detalhes</th>
                            <th scope="col">Alterar</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-revisao">
                    </tbody>
                </table>
            </div>
        </div>


    <?php } ?>

    <script type="text/javascript" src="script.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        if (status === 'ok') {
            alert('Cadastro realizado com sucesso!');
        } else if (status === 'falha') {
            alert('Erro ao cadastrar. Por favor, tente novamente.');
        }
    </script>

</body>

</html>