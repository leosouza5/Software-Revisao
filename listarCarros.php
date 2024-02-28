<?php  

require('db_services.php');

$conexao = new DbService();

$id = $_GET['regi'];

$listaClientes = $conexao->recuperar("*", "clientes", "", "nome_cliente");
$listaVeiculos = $conexao->recuperar("*","vw_carros","idcliente = '$id'","");
$listaMarca = $conexao->recuperar("*", "marca", "", "");
#print_r($listaVeiculos);



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
    <script src="https://kit.fontawesome.com/2afc7f22a6.js" crossorigin="anonymous"></script>
    <title>Cadastro de Veículos</title>
</head>
<body style="background-color: #eee;">

    <!-- CABECALHO SITE -->

    <header style="background-color: #CF1223; height: 13vh;" class="row no-gutters cabecalho align-items-center shadow-sm">

        <div class="col-12 d-flex justify-content-sm-around" >
        
            <button onclick="window.close();" class="btn btn-dark mr-2">Voltar</button>
            <button class="btn btn-dark"><i class="fa-solid fa-plus"></i></button>
  
        </div>
          
    </header>

    <div class="row no-gutters justify-content-center mt-2">
    </div>




    <!-- Lista Veiculos-->

<?php

    $cont = 1;            
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
                </tr>
              </thead>
              <tbody>

            <?php foreach($listaVeiculos as $veiculo){ ?>

                
          
            <tr class="hover">
              <th scope="row"><?=$cont++?></th>
              <td><?= $veiculo['nome']?></td>
              <td><?= $veiculo['marca']?></td>
              <td><?= $veiculo['nomecliente']?></td>
            </tr>
           
        
 


            <?php } ?>
             </tbody>
            </table>
        </div>
    </div>




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
