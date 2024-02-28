<?php  

require('db_services.php');

if (!isset($_POST) || empty($_POST)) {
    $listar = 'S';
    } else {
        if (isset($_POST['acao']) && $_POST['acao'] === 'listar') {
            $listar = 'S';
        } else {
            $listar = 'N';
        }
    }

$conexao = new DbService();
$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");

$listaCarros = $conexao->recuperar("*", "carros", "", "nome");
$listaRevisoes = $conexao->recuperar("*","vw_revisao","","data");
print_r($listaRevisoes);


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

<header style="background-color: #CF1223; height: 13vh;" class="row no-gutters cabecalho align-items-center shadow-sm">
    <div class="col-12 text-center" >
        <button onclick="paginaPorPost('listar','revisoes.php')" class="btn btn-dark mr-2">Listar</button>
        <button onclick="paginaPorPost('cadastro','revisoes.php')" class="btn btn-dark mr-2">Cadastrar</button>
        <a href="index.php" class="btn btn-dark mr-2">Voltar</a>
    </div>
</header>

<div class="row no-gutters justify-content-center mt-2"></div>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'cadastro') { ?>
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
                <select class="form-control" id="cliente" name="cliente" required>
                    <option value="">Selecione o cliente</option>
                    <?php foreach($listaClientes as $cliente) { ?>
                        <option value="<?= $cliente['id']?>"><?= $cliente['nome_cliente']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group rounded shadow p-4">
                <label for="carro">Carro</label>
                <span style="display: none;" id="erro-revisao-carro" class="alert alert-info ">Por favor, informe um carro válido!</span>
                <select class="form-control" id="carro" name="carro" required>
                    <option value="">Selecione o carro</option>
                    <?php foreach($listaCarros as $carro) { ?>
                        <option value="<?= $carro['id_carro']?>"><?= $carro['nome']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group rounded shadow p-4">
                <label for="data">Data</label>
                <span style="display: none;" id="erro-revisao-data" class="alert alert-info ">Por favor, informe uma data válida!</span>
                <input class="form-control" type="date" id="data" name="data" required>
            </div>
        </div>
    </form>
    <div class="text-center">
        <button onclick="validaFormRevisao()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar</button>
    </div>
<?php } ?>



<?php

    $cont = 1;

 if($listar == 'S'){
            
         ?>
  
   <div style="height: 86vh;" class="row no-gutters overflow-auto">
        <div class="col-12">
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
              <tbody>

            <?php foreach($listaRevisoes as $revisao){ 

                $data = explode('-',$revisao['data']);

                print_r($data);
                $data = "$data[2]/$data[1]/$data[0]";

                ?>

                
          
            <tr class="hover">
              <th scope="row"><?=$cont++?></th>
              <td><?= $revisao['nomecliente']?></td>
              <td><?= $data ?></td>
              <td><?= $revisao['nomecarro']?></td>
              <td><?= $revisao['observacao']?></td>              
              <td><button onclick="abrirAlterar(<?= $revisao['id_revisao'] ?>,'revisao')" class="btn btn-warning">Alterar</button></td>
            </tr>
           
        
 


            <?php } ?>
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
