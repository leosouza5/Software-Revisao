<?php  

	if (isset($_GET['acao']) && $_GET['acao'] == 'cadastrar') {
        $listar = 'N';
    } else {
        $listar = 'S';
    }


		require('funcoes.php');
		require('db_services.php');

		$conexao = new DbService();

		$listaCliente = $conexao->recuperar("*","clientes","","nome_cliente");

		#print_r($listaCliente);
	

 ?>


 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 	<link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
 	<title>Software-Revisao</title>
 </head>
 <body style="background-color: #eee;">

 	<!--CABECALHO SITE-->

 	<header style="background-color: #CF1223; height: 13vh;" class="row no-gutters cabecalho align-items-center shadow-sm">

 		<div class="col-6 text-center">
 			<h1 class="text-white"><?php if($listar =='N'){echo 'Cadastro';}else{echo 'Listar';} ?> Proprietários</h1>
 		</div>

 		<div class="col-6 text-center" >
 			
 			<a href="clientes.php"  class="btn btn-dark mr-2">Listar</a>
 			<a href="clientes.php?acao=cadastrar"  class="btn btn-dark mr-2">Cadastrar</a>
 			<a href="carros.php"  class="btn btn-dark mr-2">Carros</a>
 			<a href="index.php" class="btn btn-dark mr-2">Voltar</a>

  
 		</div>
	      


   	
  </header>

  <div class="row no-gutters justify-content-center mt-2">
  </div>

<!-- Lista Clientes-->

<?php

	$cont = 1;

 if($listar == 'S'){
			
		 ?>
  
   <div style="height: 77vh;" class="row no-gutters overflow-auto">
  		<div class="col-12">
			<table class="table table-striped text-center">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Nome</th>
			      <th scope="col">CPF/CNPJ</th>
			      <th scope="col">Carros</th>
			      <th scope="col">Edicao</th>
			    </tr>
			  </thead>
			  <tbody>

			<?php foreach($listaCliente as $cliente){ 


				$cpf = $cliente['id'];

				$cpfMudado = limparCPF($cpf); 

				?>


				
		  
		    <tr>
		      <th scope="row"><?=$cont++?></th>
		      <td><?= $cliente['nome_cliente']?></td>
		      <td><?= $cpfMudado?></td>
		      <td><button onclick="abrirListaCarros('<?= $cpf?>')" class="btn btn-info">Visualizar</button></td>
		      <td>
		      	<div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" onclick="abrirAlterar('<?= $cpf?>','cliente')" href="#">Alterar</a>
                    <a class="dropdown-item" onclick="excluir()" href="#">Excluir</a>
                  </div>
                </div>
		      </td>
		    </tr>
		   
		


			<?php } ?>
			 </tbody>
			</table>
		</div>
	</div>


<?php } ?>


	 	<!-- cadastro cliente-->

 	<?php if($listar == 'N'){
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
			       <input class="form-control" onkeypress="soNumero(event);" oninput="mascaraCPF(this)"  type="text" id="dados-cliente-cpf" maxlength="14" name="cpf-cnpj" required>
			     </div>

			     <!-- TELEFONE-->

			     <div class="form-group rounded shadow p-4">
				   <label for="dados-cliente-tel">Telefone</label>
			       <span style="display: none;" id="erro-cliente-tel" class="alert alert-info ">Porfavor informe um Número válido</span>
			       <input class="form-control" type="text" maxlength="11" onkeypress="soNumero(event);" id="dados-cliente-tel" placeholder="Exemplo : 67999999999" name="telefone" required>
				 </div>
				 
	 		</div>
		</form>
		<div class="text-center">
		 	<button onclick="validaFormCliente()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar</button>
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