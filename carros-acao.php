<?php  

require('db_services.php');

$conexao = new DbService();


$carroSelecionado = $conexao->recuperar("*","vw_carros","id_carro =" . $_GET['regi'],"");

$arrayCarro = $carroSelecionado[0];



$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");
#print_r($listaClientes);
$listaVeiculos = $conexao->recuperar("*","vw_carros","","");
$listaMarca = $conexao->recuperar("*", "marca", "", "");

#print_r($listaMarca);

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
    <title>Cadastro de Veículos</title>
</head>
<body style="background-color: #eee;">

    <div class="col-8 text-center">
        <!-- form ficticio para excluir carro-->
        <form id="form-excluir" action="processa-exclusao-veiculo.php?regi=<?=$_GET['regi']?>" method="POST" style="display: none;">
            <input type="hidden" name="id_carro" value="<?=$_GET['regi']?>">
        </form>

        <h1 class="d-inline">Alterar Veiculo</h1>
        <span><button onclick="excluir()" class="btn btn-danger d-inline"> EXCLUIR</button></span>
    </div>

    <!-- Formulário de Cadastro de Veículo -->

    <?php 
       /* if(isset($_POST) && isset($_POST['acao'])){
        if($_POST['acao'] == 'cadastro'){*/
     ?>
        <form action="processa-alteracao-veiculo.php?regi= <?=$_GET['regi']?>" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 86vh;" id="form-cadveiculo">

     <div class="col-md-8">
        


        







        <!-- Nome do Veículo -->
        <div class="form-group rounded shadow p-4">
            <label for="dados-veiculo-nome">Nome do Veículo</label>
            <span style="display: none;" id="erro-veiculo-nome" class="alert alert-info">Por favor, informe o nome do veículo</span>
            <input class="form-control" type="text" id="dados-veiculo-nome" maxlength="60" name="nome" value="<?php echo $arrayCarro['nome']; ?>" required>
        </div>

        <!-- Marca do Veículo -->
        <div class="form-group rounded shadow p-4">
            <label for="dados-veiculo-marca">Marca do Veículo</label>
            <span style="display: none;" id="erro-veiculo-marca" class="alert alert-info">Por favor, informe a marca do veículo</span>
            <select class="form-control" id="dados-veiculo-marca" name="marca" required>
                <option value="">Selecione a Marca</option>
                <?php foreach ($listaMarca as $marca) { ?>
                    <option value="<?= $marca['id_marca'] ?>" <?php if ($marca['id_marca'] == $arrayCarro['idmarca']) echo 'selected'; ?>><?= $marca['nome'] ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Placa do Veículo -->
        <div class="form-group rounded shadow p-4">
            <label for="dados-veiculo-placa">Placa do Veículo</label>
            <span style="display: none;" id="erro-veiculo-placa" class="alert alert-info">Por favor, informe a placa do veículo</span>
            <input class="form-control" type="text" id="dados-veiculo-placa" name="placa" value="<?php echo $arrayCarro['placa']; ?>" required>
        </div>

        <!-- Cliente Proprietário -->
        <div class="form-group rounded shadow p-4">
            <label for="dados-veiculo-cliente">Cliente Proprietário</label>
            <span style="display: none;" id="erro-veiculo-cliente" class="alert alert-info">Por favor, selecione o cliente proprietário</span>
            <select class="form-control" id="dados-veiculo-cliente" name="cliente" required>
                <option value="">Selecione o cliente</option>
                <?php foreach ($listaClientes as $cliente) { ?>
                    <option value="<?= $cliente['id'] ?>" <?php if ($cliente['id'] == $arrayCarro['idcliente']) echo 'selected'; ?>><?= $cliente['nome_cliente'] ?></option>
                <?php } ?>
            </select>
        </div>

    </div>
</form>

        <div class="text-center">
            <button onclick="validaFormVeiculo()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar</button>
            <button onclick="window.close();" class="btn btn-info"> Cancelar </button>
        </div>

    <?php //} } ?>







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
</script>

</body>
</html>
