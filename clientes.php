<?php

require('header.php');

if (isset($_GET['acao']) && $_GET['acao'] == 'cadastrar') {
    $listar = 'N';
} else {
    $listar = 'S';
}



#print_r($listaCliente);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/2afc7f22a6.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <title>Software-Revisao</title>
</head>

<body onload="recuperarListaClientes()" style="background-color: #eee;">
    <!-- Lista Clientes-->
    <?php

    $cont = 1;

    if ($listar == 'S') {

    ?>
        <div style="height: 77vh;" class="row no-gutters overflow-auto">
            <div class="col-12">
                <div class="row no-gutters">
                    <div class="col-4 text-center">
                        <span>
                            <h1 class="m-3 d-inline">Clientes</h1>
                            <a href="clientes.php?acao=cadastrar" class="btn btn-info d-inline"><i class="fa-solid fa-plus"></i></a>
                        </span>
                    </div>
                    <div class="col-2 text-center align-items-center" id="carregando"></div>
                    <div class="col-6">
                        <div class="input-group my-3">
                            <div class="input-group-prepend" id="button-addon3">
                                <select class="custom-select" name="asda" id="pes_filtro_parametro">
                                    <option value="nome_cliente">Nome</option>
                                    <option value="cpf">CPF</option>
                                </select>
                            </div>
                            <input type="text" onkeyup="buscarCliente()" class="form-control" placeholder="" id="pes_filtro_texto" aria-label="Example text with two button addons" aria-describedby="button-addon3">
                        </div>
                    </div>
                </div>
                <table id="table-lista-clientes" class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF/CNPJ</th>
                            <th scope="col">Carros</th>
                            <th scope="col">Edicao</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-clientes">
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <!-- cadastro cliente-->
    <?php if ($listar == 'N') {
    ?>
        <form action="processa-cadastro.php" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 77vh;" id="form-cadclie">
            <div class="col-md-8 ">
                <!-- NOME-->
                <div class="form-group rounded shadow p-4">
                    <label for="dados-cliente-nome">Nome Completo</label>
                    <span style="display: none;" id="erro-cliente-nome" class="alert alert-info ">Porfavor informe um nome válido</span>
                    <input class="form-control" type="text" maxlength="60" id="dados-cliente-nome" name="nome" required>
                </div>
                <!-- GENERO-->
                <div class="form-group rounded shadow p-4">
                    <label for="listaCateg">Gênero</label>
                    <span style="display: none;" id="erro-cliente-gen" class="alert alert-info ">Porfavor informe uma opção válida</span>
                    <select id="dados-cliente-gen" name="genero" class="custom-select">
                        <option value="false" selected>Escolha</option>
                        <option value="H">Homem</option>
                        <option value="M">Mulher</option>
                        <option value="O">Outro</option>
                    </select>
                </div>
                <!-- CPF/CNPJ-->
                <div class="form-group rounded shadow p-4">
                    <label for="dados-cliente-cpf">CPF/CNPJ</label>
                    <span style="display: none;" id="erro-cliente-cpf" class="alert alert-info ">Porfavor informe um CPF/CNPJ válido</span>
                    <input class="form-control" onkeypress="soNumero(event);" oninput="mascaraCPF(this)" onblur="validaCPF(this.value)" type="text" id="dados-cliente-cpf" maxlength="14" name="cpf-cnpj" required>
                </div>
                <!-- TELEFONE-->
                <div class="form-group rounded shadow p-4">
                    <label for="dados-cliente-tel">Telefone</label>
                    <span style="display: none;" id="erro-cliente-tel" class="alert alert-info ">Porfavor informe um Número válido</span>
                    <input class="form-control" oninput="mascaraCelular(this)" type="text" maxlength="11" onkeypress="soNumero(event);" id="dados-cliente-tel" placeholder="Exemplo : 67999999999" name="telefone" required>
                </div>
            </div>
        </form>
        <div class="row fixed-bottom bg-dark">
            <div class="col-12 text-center py-2">
                <button id="enviar" onclick="validaFormCliente()" class="btn btn-light" style="font-weight: 500;">Confirmar</button>
            </div>
        </div>
    <?php } ?>











    <!-- MODAL CARROS POR CLIENTE -->
    <div class="modal fade" id="modal-carros-cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg " role="document">
            <div style="background-color:#eee;" class="modal-content">
                <!-- HEADER DO MODAL-->
                <div class="modal-header bg-dark">
                    <h5 style="color:white;" class="modal-title" id="titulo-modal">Carros do Cliente : <span id="modal-titulo-cliente"></span></h5>
                    <!-- TITULO DO MODAL-->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i style="color:white; font-weight: 700;" class="fa-solid fa-circle-xmark"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- CORPO DO MODAL -->
                    <div class="row no-gutters overflow-auto">
                        <div class="col-12" id='divDinamica'>
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Carro</th>
                                        <th scope="col">Marca</th>
                                        <th scope="col">Cliente</th>
                                    </tr>
                                </thead>
                                <tbody id="table-modal">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- RODAPE MODAL -->
                <div class="d-flex justify-content-between modal-footer">
                    <a href="carros.php?acao=cadastrar" class="btn btn-secondary">Novo</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="script.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'ok') {
            alert('Operação realizada com sucesso!');
        } else if (status === 'falha') {
            alert('Erro ao processar . Por favor, tente novamente.');
        }
    </script>
</body>

</html>