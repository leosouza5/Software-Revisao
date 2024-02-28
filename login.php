<?php 

	require('db_services.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	 <script src="ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        /* Estilos adicionais podem ser colocados aqui */
        body, html {
            height: 100%;
            background: #eee;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .login-form {
            background-color: #fff;
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <form class="login-form" method="POST" action="processa-login.php">
        <h2 class="text-center mb-4">Login</h2>
        <div class="form-group">
            <label for="username">Usuário</label>
            <input required type="text" class="form-control" name="login" id="login-usuario" placeholder="Informe seu usuário">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input required type="password" class="form-control" name="senha" id="login-senha" placeholder="Informe sua senha">
        </div>
        <button type="submit" class="btn btn-danger btn-block hover">Enviar</button>
    </form>
</div>



</body>
</html>