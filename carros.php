<?php  

if (isset($_GET['acao']) && $_GET['acao'] == 'cadastrar') {
        $listar = 'N';
    } else {
        $listar = 'S';
    }



require('db_services.php');

$conexao = new DbService();

$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");
#print_r($listaClientes);
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
    <title>Cadastro de Veículos</title>
</head>
<body style="background-color: #eee;">

    <!-- CABECALHO SITE -->

    <header style="background-color: #CF1223; height: 13vh;" class="row no-gutters cabecalho align-items-center shadow-sm">

        <div class="col-12 text-center" >
            
            <a href="carros.php" class="btn btn-dark mr-2">Listar</a>
            <a href="carros.php?acao=cadastrar" class="btn btn-dark mr-2">Cadastrar</a>
            <a href="clientes.php" class="btn btn-dark mr-2">Voltar</a>
  
        </div>
          
    </header>

    <div class="row no-gutters justify-content-center mt-2">
    </div>

    <!-- Formulário de Cadastro de Veículo -->

    <?php 
        if($listar == 'N'){ 
     ?>
        <div id="div-mandar">
            <form action="processa-cadastro-veiculo.php" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 86vh;" id="form-cadveiculo">

                <div class="col-md-8 ">
                    <h1>Cadastro de Veículo</h1>

                    <!-- Nome do Veículo -->
                     <div class="form-group rounded shadow p-4">
                       <label for="dados-veiculo-nome">Nome do Veículo</label>
                       <span style="display: none;" id="erro-veiculo-nome" class="alert alert-info ">Por favor, informe o nome do veículo</span>
                       <input class="form-control" type="text" id="dados-veiculo-nome" maxlength="60" name="nome" required>
                     </div>

                        <!-- Marca do Veículo -->
                     <div class="form-group rounded shadow p-4">
                       <label for="dados-veiculo-marca">Marca do Veículo</label>
                       <span style="display: none;" id="erro-veiculo-marca" class="alert alert-info ">Por favor, informe a marca do veículo</span>
                       <select class="form-control" id="dados-veiculo-marca" name="marca" required>
                            <option value="">Selecione a Marca</option>
                            <?php foreach($listaMarca as $marca) { ?>
                               <option value="<?= $marca['id_marca']?>"><?= $marca['nome']?></option>
                            <?php } ?>
                        </select>
                     </div>

                     <!-- Placa do Veículo -->
                     <div class="form-group rounded shadow p-4">
                       <label for="dados-veiculo-placa">Placa do Veículo</label>
                       <span style="display: none;" id="erro-veiculo-placa" class="alert alert-info ">Por favor, informe a placa do veículo</span>
                       <input class="form-control" type="text" id="dados-veiculo-placa" name="placa" required>
                     </div>

                     <!-- Cliente Proprietário -->
                     <div class="form-group rounded shadow p-4">
                       <label for="dados-veiculo-cliente">Cliente Proprietário</label>
                       <span style="display: none;" id="erro-veiculo-cliente" class="alert alert-info ">Por favor, selecione o cliente proprietário</span>
                       <select class="form-control" id="dados-veiculo-cliente" name="cliente" required>
                           <option value="">Selecione o cliente</option>
                           <?php foreach($listaClientes as $cliente) { ?>
                               <option value="<?= $cliente['id']?>"><?= $cliente['nome_cliente']?></option>
                           <?php } ?>
                       </select>
                     </div>

                     <div class="text-center">
                        <a href="#" onclick="validaFormVeiculo()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar</a href="#">
                    </div>
                     
                </div>

                
            </form>
            
        </div>

    <?php } ?>



    <!-- Lista Veiculos-->

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
                  <th scope="col">Carro</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Cliente</th>
                  <th scope="col">Edicao</th>
                </tr>
              </thead>
              <tbody>

            <?php foreach($listaVeiculos as $veiculo){ ?>

                
          
            <tr class="hover">
              <th scope="row"><?=$cont++?></th>
              <td><?= $veiculo['nome']?></td>
              <td><?= $veiculo['marca']?></td>
              <td><?= $veiculo['nomecliente']?></td>
              <td><button onclick="abrirAlterar(<?= $veiculo['id_carro'] ?>,'carros')" class="btn btn-warning">Alterar</button></td>
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
