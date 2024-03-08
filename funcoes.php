<?php   

    function limparCPF($cpf) {
        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf);
        return $cpf;
    }


    function limparTelefone($numero) {
        return preg_replace('/\D/', '', $numero);
    }

    function mascaraCPF($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf);

        $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

        return $cpfFormatado;
}


?>