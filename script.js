






function soNumero(e){
    var tecla = e.which || e.keyCode;
    if (tecla < 48 || tecla > 57) {
        e.preventDefault();
    }
}

function mascaraCPF(campo) {
    campo.maxLength = 14; // Define o tamanho máximo do campo
    var valor = campo.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto após o terceiro dígito
    valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto após o sexto dígito
    valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o traço após o nono dígito, se houver
    campo.value = valor; // Define o valor formatado no campo
    validarCPF(campo); // Chama a função de validação
}

function limparCPF(cpf) {
    cpf = cpf.replace(/\./g, '');
    cpf = cpf.replace('-', '');
    return cpf;
}
        



function verificaRetorno(){
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'ok') {
        alert('Cadastro realizado com sucesso!');
    } else if (status === 'falha') {
        alert('Erro ao cadastrar. Por favor, tente novamente.');
    }
}





function paginaPorPost(valor,rotina) {
        
        //criando formulario ficticio para recarregar pagina

        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', rotina); 

        // adiciona o campo de input com o valor a ser passado
        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'acao');
        input.setAttribute('value', valor);
        form.appendChild(input);

        
        document.body.appendChild(form);
        form.submit();
    }



function abrirAlterar(id,rotina){
      
    var novaJanela = window.open(rotina+"-acao.php?regi=" + id, "NovaJanela", "width=1280,height=720");
}

function abrirListaCarros(id){
    var novaJanela = window.open("listarCarros.php?regi=" + id, "NovaJanela", "width=1280,height=720");
  
}



function validaFormCliente(){

    var form = document.getElementById('form-cadclie')
    var nomeCliente = document.getElementById('dados-cliente-nome').value.trim()
    var GenCliente = document.getElementById('dados-cliente-gen').value
    var CpfCliente = document.getElementById('dados-cliente-cpf').value
    var TelCliente = document.getElementById('dados-cliente-tel').value

    var campoErroNome = document.getElementById('erro-cliente-nome')
    var campoErroGen = document.getElementById('erro-cliente-gen')
    var campoErroCpf = document.getElementById('erro-cliente-cpf')
    var campoErroTel = document.getElementById('erro-cliente-tel')

    if(nomeCliente == ''){
        campoErroNome.style.display ='inherit'   //verifica se existe um nome informado
        return
    }else{
        campoErroNome.style.display ='none'
    }

    if(GenCliente == 'false'){
        campoErroGen.style.display ='inherit'   //verifica se informou um genero
        return
    }else{
        campoErroGen.style.display ='none'
    }

    if (CpfCliente.length < 11 || CpfCliente.length > 14) {
        campoErroCpf.style.display = 'inherit'; // Verifica tamanho do cpf
        return;
    } else {
        verificarCPF(CpfCliente, function (existe) {             //verifica se cpf ou cnpj ja esta cadastrado
            if (existe) {
                alert('CPF OU CNPJ JA ESTA CADASTRADO')
                campoErroCpf.style.display = 'inherit';
            } else {
                campoErroCpf.style.display = 'none';
                if (TelCliente.length < 8 || TelCliente.length > 11) {
                    campoErroTel.style.display = 'inherit';  //verifica se telefone esta no padrao
                    return;
                } else {
                    campoErroTel.style.display = 'none';
                    form.submit(); 
                }
            }
        });
    }

}

function validaFormClienteSemCpf(){

    var form = document.getElementById('form-cadclie')
    var nomeCliente = document.getElementById('dados-cliente-nome').value.trim()
    var GenCliente = document.getElementById('dados-cliente-gen').value
    var CpfCliente = document.getElementById('dados-cliente-cpf').value
    var TelCliente = document.getElementById('dados-cliente-tel').value

    var campoErroNome = document.getElementById('erro-cliente-nome')
    var campoErroGen = document.getElementById('erro-cliente-gen')
    var campoErroCpf = document.getElementById('erro-cliente-cpf')
    var campoErroTel = document.getElementById('erro-cliente-tel')

    if(nomeCliente == ''){
        campoErroNome.style.display ='inherit'   //verifica se existe um nome informado
        return
    }else{
        campoErroNome.style.display ='none'
    }

    if(GenCliente == 'false'){
        campoErroGen.style.display ='inherit'   //verifica se informou um genero
        return
    }else{
        campoErroGen.style.display ='none'
    }

    if (CpfCliente.length < 11 || CpfCliente.length > 14) {
        campoErroCpf.style.display = 'inherit'; // Verifica tamanho do cpf
        return;
    }else {
        campoErroCpf.style.display = 'none';
        if (TelCliente.length < 8 || TelCliente.length > 11) {
            campoErroTel.style.display = 'inherit';  //verifica se telefone esta no padrao
            return;
        } else {
            campoErroTel.style.display = 'none';
            form.submit(); 
        }
    }
    
}


function validaFormVeiculo() {
    var form = document.getElementById('form-cadveiculo');
    var marcaVeiculo = document.getElementById('dados-veiculo-marca').value
    var placaVeiculo = document.getElementById('dados-veiculo-placa').value.trim();
    var nomeVeiculo = document.getElementById('dados-veiculo-nome').value.trim();
    var clienteVeiculo = document.getElementById('dados-veiculo-cliente').value;

    var campoErroMarca = document.getElementById('erro-veiculo-marca');
    var campoErroNome= document.getElementById('erro-veiculo-nome');
    var campoErroPlaca = document.getElementById('erro-veiculo-placa');
    var campoErroCliente = document.getElementById('erro-veiculo-cliente');

      if (nomeVeiculo == '') {
        campoErroNome.style.display = 'inherit'; // verifica se existe um modelo informado
        return;
    } else {
        campoErroNome.style.display = 'none';
    }


    if (marcaVeiculo == '') {
        campoErroMarca.style.display = 'inherit'; // verifica se existe uma marca informada
        return;
    } else {
        campoErroMarca.style.display = 'none';
    }

  
    if (placaVeiculo.length < 7 || placaVeiculo.length > 8) {
        campoErroPlaca.style.display = 'inherit'; // verifica se a placa está no formato correto
        return;
    } else {
        campoErroPlaca.style.display = 'none';
    }

    if (clienteVeiculo == '') {
        campoErroCliente.style.display = 'inherit'; // verifica se a placa está no formato correto
        return;
    } else {
        campoErroCliente.style.display = 'none';
    }   

    form.submit();
}
function validaFormRevisao() {
    var form = document.getElementById('form-cadrevisao');
    var observacao = document.getElementById('observacao').value.trim();
    var cliente = document.getElementById('cliente').value;
    var carro = document.getElementById('carro').value;
    var data = document.getElementById('data').value;

    var campoErroObservacao = document.getElementById('erro-revisao-observacao');
    var campoErroCliente = document.getElementById('erro-revisao-cliente');
    var campoErroCarro = document.getElementById('erro-revisao-carro');
    var campoErroData = document.getElementById('erro-revisao-data');

    if (observacao === '') {
        campoErroObservacao.style.display = 'inherit';
        return;
    } else {
        campoErroObservacao.style.display = 'none';
    }

    if (cliente === '') {
        campoErroCliente.style.display = 'inherit';
        return;
    } else {
        campoErroCliente.style.display = 'none';
    }

    if (carro === '') {
        campoErroCarro.style.display = 'inherit';
        return;
    } else {
        campoErroCarro.style.display = 'none';
    }

    if (data === '') {
        campoErroData.style.display = 'inherit';
        return;
    } else {
        campoErroData.style.display = 'none';
    }

    // Se todos os campos estiverem preenchidos, você pode enviar o formulário
    form.submit();
}




function verificarCPF(cpf,callback) {


    var ajax = new XMLHttpRequest();
    ajax.open('GET', "verificaCpf.php?cpf=" + cpf, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var resposta = JSON.parse(ajax.responseText);
            if (resposta.existe) {
                callback(true);
            } else {
                callback(false);
            }
        }
    };
    // Envia o CPF para o script PHP
    ajax.send('cpf=' + cpf);
}


function excluir() {
    if (confirm('Tem certeza de que deseja excluir este carro?')) {
        document.getElementById('form-excluir').submit();
    }
}



function requestConteudo(link,divExterna,divInterna,origem){

    var ajax = new XMLHttpRequest();
    ajax.open('GET', link, true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var tempElement = document.createElement('div');

            tempElement.innerHTML = ajax.responseText;



            var divConteudo = tempElement.querySelector('#' + divExterna);


            //Cria input contendo a origem para retornar

            var origemInput = document.createElement('input');
            origemInput.type = 'hidden';
            origemInput.name = 'origem';
            origemInput.value = origem;

            divConteudo.appendChild(origemInput);





            var divDinamica = document.getElementById(divInterna);

            divDinamica.innerHTML = '';

            divDinamica.appendChild(divConteudo);



            


        }else {
            console.error('Erro ao carregar o conteúdo:', ajax.status);
        }
    };
    ajax.send();

}