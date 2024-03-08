<?php  

require('db_services.php');

$conexao = new DbService();

$id = $_GET['regi'];

$clienteSelecionado = $conexao->recuperar("*", "clientes", "id = '$id'", "");
$arrayCliente = $clienteSelecionado[0];

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
    <title>Alteração de Cliente</title>
</head>
<body style="background-color: #eee;">

    <div class="col-8 text-center">
        <!-- Formulário fictício para excluir cliente-->
        <form id="form-excluir" action="processa-exclusao-cliente.php?regi=<?= $_GET['regi'] ?>" method="POST" style="display: none;">
            <input type="hidden" name="id_cliente" value="<?= $_GET['regi'] ?>">
        </form>

        <h1 class="d-inline">Alterar Cliente</h1>
    </div>

    <!-- Formulário de Alteração de Cliente -->
    <form action="processa-alteracao-cliente.php?regi=<?= $_GET['regi'] ?>" method="POST" class="row no-gutters mt-2 p-3 rounded justify-content-center overflow-auto" style="height: 86vh;" id="form-cadclie">
        <div class="col-md-8">
            <!-- Nome do Cliente -->
            <div class="form-group rounded shadow p-4">
                <label for="dados-cliente-nome">Nome do Cliente</label>
                <span style="display: none;" id="erro-cliente-nome" class="alert alert-info">Por favor, informe o nome do cliente</span>
                <input class="form-control" type="text" id="dados-cliente-nome" maxlength="60" name="nome" value="<?php echo $arrayCliente['nome_cliente']; ?>" required>
            </div>


            <div class="form-group rounded shadow p-4">
                <label for="dados-cliente-genero">Gênero do Cliente</label>
                <span style="display: none;" id="erro-cliente-gen" class="alert alert-info">Por favor, selecione o gênero do cliente</span>
                <select class="form-control" id="dados-cliente-gen" name="genero" required>
                    <option value="">Selecione o gênero</option>
                    <option value="H" <?php if ($arrayCliente['genero'] == 'H') echo 'selected'; ?>>Masculino</option>
                    <option value="M" <?php if ($arrayCliente['genero'] == 'M') echo 'selected'; ?>>Feminino</option>
                    <option value="O" <?php if ($arrayCliente['genero'] == 'O') echo 'selected'; ?>>Outro</option>
                </select>
            </div>

            <!-- CPF/CNPJ do Cliente -->
            <div class="form-group rounded shadow p-4">
                <label for="dados-cliente-cpf">CPF/CNPJ do Cliente</label>
                <span style="display: none;" id="erro-cliente-cpf" class="alert alert-info">Por favor, informe o CPF/CNPJ do cliente</span>
                <input class="form-control" type="text" id="dados-cliente-cpf" name="cpf_cnpj" value="<?php echo $arrayCliente['id']; ?>" required>
            </div>

            <!-- Telefone do Cliente -->
            <div class="form-group rounded shadow p-4">
                <label for="dados-cliente-telefone">Telefone do Cliente</label>
                <span style="display: none;" id="erro-cliente-tel" class="alert alert-info">Por favor, informe o telefone do cliente</span>
                <input class="form-control" type="text" id="dados-cliente-tel" name="telefone" value="<?php echo $arrayCliente['telefone']; ?>" required>
            </div>
        </div>
    </form>

    <div class="text-center fixed-bottom">
        <button onclick="validaFormClienteSemCpf()" class="btn btn-danger" style="color: white; background-color: rgb(207, 18, 35); font-weight: 500;">Confirmar Alteração</button>
        <button onclick="window.close();" class="btn btn-info">Cancelar</button>
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
