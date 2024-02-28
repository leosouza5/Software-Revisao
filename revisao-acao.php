<?php  

require('db_services.php');

$conexao = new DbService();

$revisaoSelecionada = $conexao->recuperar("*","vw_revisao","id_revisao =" . $_GET['regi'],"");
$arrayRevisao = $revisaoSelecionada['0'];


#print_r($revisaoSelecionada);

$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");
$listaVeiculos = $conexao->recuperar("*","vw_carros","","");
$listaMarca = $conexao->recuperar("*", "marca", "", "");

?>

<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <title>Cadastro de Revisões</title>
</head>
<body style="background-color: #eee;">

     <!-- form ficticio para excluir carro-->
    <form id="form-excluir" action="processa-exclusao-revisao.php?regi=<?=$_GET['regi']?>" method="POST" style="display: none;">
        <input type="hidden" name="id_revisao" value="<?=$_GET['regi']?>">
    </form>

    <div class="col-8 text-center">
        <h1 class="d-inline">Alterar Revisão</h1>
        <span><button onclick="excluir()" class="btn btn-danger d-inline"> EXCLUIR</button></span>
    </div>

    <!-- Formulário de Cadastro de Revisão -->
    <form action="processa-alteracao-revisao.php?regi=<?=$_GET['regi']?>" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 86vh;" id="form-cadrevisao">
        <div class="col-md-8">
            <!-- Observação da Revisão -->
            <div class="form-group rounded shadow p-4">
                <label for="observacao">Observação</label>
                <span style="display: none;" id="erro-revisao-observacao" class="alert alert-info ">Por favor, informe uma observação valida !</span>
                <textarea class="form-control" id="observacao" name="observacao" required><?php echo $arrayRevisao['observacao']; ?></textarea>
            </div>
            <!-- Cliente Proprietário -->
            <div class="form-group rounded shadow p-4">
                <label for="cliente">Cliente</label>
                <span style="display: none;" id="erro-revisao-cliente" class="alert alert-info ">Por favor, informe um cliente valido!</span>
                <select class="form-control" id="cliente" name="cliente" required>
                    <option value="">Selecione o cliente</option>
                    <?php foreach ($listaClientes as $cliente) { ?>
                    <option value="<?= $cliente['id'] ?>" <?php if ($cliente['id'] == $arrayRevisao['idcliente']) echo 'selected'; ?>><?= $cliente['nome_cliente'] ?></option>
                <?php } ?>
                </select>
            </div>
            <!-- Carro -->
            <div class="form-group rounded shadow p-4">
                <label for="carro">Carro</label>
                <span style="display: none;" id="erro-revisao-carro" class="alert alert-info ">Por favor, informe um carro válido!</span>
                <select class="form-control" id="carro" name="carro" required>
                    <option value="">Selecione o carro</option>
                    <?php foreach ($listaVeiculos as $veiculo) { ?>
                    <option value="<?= $veiculo['id_carro'] ?>" <?php if ($veiculo['id_carro'] == $arrayRevisao['idcarro']) echo 'selected'; ?>><?= $veiculo['nome'] ?></option>
                <?php } ?>
                </select>
            </div>
            <!-- Data -->
            <div class="form-group rounded shadow p-4">
                <label for="data">Data</label>
                <span style="display: none;" id="erro-revisao-data" class="alert alert-info ">Por favor, informe uma data válida!</span>
                <input class="form-control" type="date" id="data" name="data" value="<?php echo $arrayRevisao['data']; ?>" required>
            </div>
        </div>
    </form>
    <div class="text-center">
        <button onclick="validaFormRevisao()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar</button>
        <button onclick="window.close();" class="btn btn-info"> Cancelar </button>
    </div>

    <script type="text/javascript" src="script.js"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'ok') {
            alert('Alteração realizada com sucesso!');
             window.opener.location.reload();
            window.close();
        } else if (status === 'falha') {
            alert('Erro ao atualizar. Por favor, tente novamente.');
             window.opener.location.reload();
            window.close();
        } else if (status === 'nada') {
            alert('Não foi possível encontrar os dados para alteração!');
             window.opener.location.reload();
            window.close();
        }
    </script>

</body>
</html>
