<?php

require('db_services.php');

$conexao = new DbService();


$cpf = $_GET['cpf'];


$resultado = $conexao->recuperar("COUNT(*) AS total", "clientes", "id = '$cpf'", "");





$total = $resultado['0']['total'];

echo json_encode(['existe' => $total > 0]);
?>
