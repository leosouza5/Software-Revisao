var listaCliente = [];

console.log(listaCliente)


window.addEventListener('load', function() {
    limparParametrosURL();
});



function buscarCliente(){
    let pesquisa = document.getElementById('pes_filtro_texto').value.trim();
    let tipo = document.getElementById('pes_filtro_parametro').value;

    let tbody = document.getElementById('tabela-clientes');
    tbody.innerHTML = '';
    let contador = 1;

    listaCliente.forEach(function(valor){
        parametro = tipo == 'nome_cliente' ? valor.nome_cliente : valor.id;
        if(parametro.indexOf(pesquisa) != -1){  
            let tr = document.createElement('tr');
                tr.innerHTML = `
                  <th scope="row">${contador}</th>
                  <td>${valor.nome_cliente}</td>
                  <td>${valor.id}</td>
                  <td><button onclick="abrirListaCarros('${valor.id}')" class="btn btn-info">Visualizar</button></td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" onclick="abrirAlterar('${valor.id}','cliente')" href="#">Alterar</a>
                        <a class="dropdown-item" onclick="excluir('${valor.id}','cliente')" href="#">Excluir</a>
                      </div>
                    </div>
                  </td>
                `;

                tbody.appendChild(tr);
                contador++;

        }
    });


}

function recuperarListaClientes(metodo){


        var metodoString ="funcao:recuperar;tabela:clientes;campos:*;where:nada;orderby:nome_cliente";

        console.log(metodoString)
        let metodo64 = btoa(metodoString);

        link = "db_services.php?metodo=" + metodo64;

        console.log(link);
        if(!document.getElementById('loading')){        //INSERE LOADING
            let imgLoading = document.createElement('img')
            imgLoading.id = 'loading'
            imgLoading.src = 'img/loading.gif'
            imgLoading.width = 50;
            imgLoading.className = 'rounded mx-auto d-block'
            document.getElementById('carregando').appendChild(imgLoading);
        }

        chamarAjax(link,function(resultado){

            let tbody = document.getElementById('tabela-clientes');
            tbody.innerHTML = '';
            let contador = 1;
            
           document.getElementById('loading').remove()    //REMOVE LOADING

            resultado.forEach(function(valor,indice){

                listaCliente.push(valor);
                
                let tr = document.createElement('tr');
                tr.innerHTML = `
                      <th scope="row">${contador}</th>
                      <td>${valor.nome_cliente}</td>
                      <td>${valor.id}</td>
                      <td><button onclick="abrirListaCarros('${valor.id}')" class="btn btn-info">Visualizar</button></td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" onclick="abrirAlterar('${valor.id}','cliente')" href="#">Alterar</a>
                            <a class="dropdown-item" onclick="excluir('${valor.id}','cliente')" href="#">Excluir</a>
                          </div>
                        </div>
                      </td>
                `;

                tbody.appendChild(tr);
                contador++;

            });
            
        });

    
}


function recuperarCarros(cliente){
    var metodoString = "funcao:recuperar;tabela:carros;campos:id_carro,nome;where:cliente='" + cliente + "'";

    var metodo64 = btoa(metodoString);

    link ="db_services.php?metodo=" + metodo64;

    chamarAjax(link,function(resultado){
        let select = document.getElementById('carro');
        
        select.innerHTML = '';

        if(!resultado || resultado.length === 0){
            option =  document.createElement('option');
            option.value = ''
            option.innerHTML = "Nenhum Carro cadastrado!"          //pegando o nome e id do carro atribuindo a um OPTION e inserindo no select
            select.appendChild(option);
        }else{
            resultado.forEach(function(valor,indice){
                option =  document.createElement('option');
                option.value = valor.id_carro;
                option.innerHTML = valor.nome;          //pegando o nome e id do carro atribuindo a um OPTION e inserindo no select
                select.appendChild(option);
            });
        }
    });

    
}


function chamarAjax(link,callback){
    ajax = new XMLHttpRequest();

    ajax.open('GET',link,true); 

    ajax.onreadystatechange = () => {
        if(ajax.status == 200 && ajax.readyState == 4){

            let resultado = JSON.parse(ajax.responseText);
            console.log(resultado)

            callback(resultado);            
        }
    };

    ajax.send();
}





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
}

function mascaraCelular(campo) {
    campo.maxLength = 15; // Define o tamanho máximo do campo
    var valor = campo.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    valor = valor.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona o parêntese após o segundo dígito
    valor = valor.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen após o quinto dígito
    campo.value = valor; // Define o valor formatado no campo
}



function validaCPF(cpf){

    if(cpf != '' && !calculoValidaCPF(cpf)){
        alert("CPF INVALIDO")
        document.getElementById('dados-cliente-cpf').value = '';
        document.getElementById('enviar').disabled = true;
    }else{
        document.getElementById('enviar').disabled = false;
    }


    
}

function calculoValidaCPF(cpf) {
    // Remover caracteres não numéricos
    cpf = cpf.replace(/[^\d]/g, '');
    
    // Verificar se o CPF possui 11 dígitos
    if (cpf.length !== 11) {
        return false;
    }
    
    // Verificar se todos os dígitos são iguais
    var cpfInvalidos = [
        '00000000000', '11111111111', '22222222222', '33333333333', '44444444444',
        '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'
    ];
    if (cpfInvalidos.includes(cpf)) {
        return false;
    }

    // Calcular o primeiro dígito verificador
    var soma = 0;
    for (var i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    var resto = soma % 11;
    var digitoVerificador1 = (resto < 2) ? 0 : 11 - resto;

    // Verificar o primeiro dígito verificador
    if (parseInt(cpf.charAt(9)) !== digitoVerificador1) {
        return false;
    }

    // Calcular o segundo dígito verificador
    soma = 0;
    for (var i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = soma % 11;
    var digitoVerificador2 = (resto < 2) ? 0 : 11 - resto;

    // Verificar o segundo dígito verificador
    if (parseInt(cpf.charAt(10)) !== digitoVerificador2) {
        return false;
    }

    // Se todas as verificações passaram, o CPF é válido
    return true;
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


function alternar(id1,id2){
    div1 = document.getElementById(id1);
    div2 = document.getElementById(id2);

    console.log(div1.getAttribute("hidden"))


    if(div1.getAttribute("hidden") != null){
        div2.setAttribute("hidden","");
        div1.removeAttribute("hidden");
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
                if (TelCliente.length != 15) {
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
        if (TelCliente.length > 15) {
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
    var marcaVeiculo = document.getElementById('dados-veiculo-marca');
    var placaVeiculo = document.getElementById('dados-veiculo-placa');
    var nomeVeiculo = document.getElementById('dados-veiculo-nome');
    var clienteVeiculo = document.getElementById('dados-veiculo-cliente');

    var campoErroMarca = document.getElementById('erro-veiculo-marca');
    var campoErroNome = document.getElementById('erro-veiculo-nome');
    var campoErroPlaca = document.getElementById('erro-veiculo-placa');
    var campoErroCliente = document.getElementById('erro-veiculo-cliente');

    if (nomeVeiculo && marcaVeiculo && placaVeiculo) {
        nomeVeiculo = nomeVeiculo.value.trim();
        marcaVeiculo = marcaVeiculo.value;
        placaVeiculo = placaVeiculo.value.trim();
    } else {
        console.error("Um ou mais elementos não foram encontrados no DOM.");
        return;
    }

    if (nomeVeiculo.trim() === '') {
        campoErroNome.style.display = 'inherit';
        return;
    } else {
        campoErroNome.style.display = 'none';
    }

    if (marcaVeiculo === '') {
        campoErroMarca.style.display = 'inherit';
        return;
    } else {
        campoErroMarca.style.display = 'none';
    }

    if (placaVeiculo.length < 7 || placaVeiculo.length > 8) {
        campoErroPlaca.style.display = 'inherit';
        return;
    } else {
        campoErroPlaca.style.display = 'none';
    }

    if (clienteVeiculo) {
        clienteVeiculo = clienteVeiculo.value;
        if (clienteVeiculo === '') {
            campoErroCliente.style.display = 'inherit';
            return;
        } else {
            campoErroCliente.style.display = 'none';
        }
    }

    form.submit(); // Submete o formulário somente se não houver erros
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


function excluir(regi, tabela) {
    if (confirm('Tem certeza de que deseja excluir este registro e todos os seus vinculos ??')) {
        var link;
        switch(tabela) {
            case 'cliente':
                link = 'processa-exclusao-cliente.php?regi=' + regi + '&origem=' + tabela;
                break;

            case 'veiculo':
                link = 'processa-exclusao-veiculo.php?regi=' + regi + '&origem=' + tabela;
                break;

            case 'revisao':
                link = 'processa-exclusao-revisao.php?regi=' + regi + '&origem=' + tabela;
                break;
        }

        var ajax = new XMLHttpRequest();

        ajax.open('GET', link, true);

        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    alert(ajax.responseText); // Exibir resposta do servidor em um alerta
                    location.reload();
                } else {
                    alert("Erro: " + ajax.status); // Exibir mensagem de erro se houver algum problema com a requisição
                }
            }
        };

        ajax.send();

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




function limparParametrosURL() {
    window.history.replaceState({}, document.title, window.location.pathname);
}

