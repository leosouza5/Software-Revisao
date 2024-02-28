<?php 
if(isset($_POST)){

	#print_r($_POST);

	require('funcoes.php');
	require('db_services.php');

	$conexao = new DbService();

	$cpf = $_POST['cpf-cnpj'];
	$cpf  = limparCPF($cpf);
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];



	$resultado = $conexao->inserir("INSERT INTO leonardo.clientes (id,nome_cliente,genero,telefone) VALUES ('$cpf','$nome','$genero','$telefone')");

	if ($resultado) {

        header('location: clientes.php?status=ok');
    } else {
    	echo'deu erro';
        header('location: clientes.php?status=falha');
    }

}
?>