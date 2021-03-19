var qnt_result_pg = 6; //quantidade de registro por página
var pagina = 1; //página inicial
var nor = document.getElementById("nor").value;
var cliente = document.getElementById("codCli").value;
var iemissao = document.getElementById("iemissao").value;
var femissao = document.getElementById("femissao").value;

var corpo = document.getElementById("conteudo");
corpo.addEventListener("load", pesquisarProd(pagina, 6, nor, cliente, iemissao, femissao));
function pesquisarProd(pagina, qnt_result_pg,  nor, cliente, iemissao, femissao){
    if(nor == undefined){
        nor = document.getElementById("nor").value;
    }
    if(cliente == undefined){
        cliente = document.getElementById("codCli").value;
    }
    if(iemissao == undefined){
        iemissao = document.getElementById("iemissao").value;
    }
    if(femissao == undefined){
        femissao = document.getElementById("femissao").value;
    }
    var dados = {
        pagina: pagina,
        qnt_result_pg: qnt_result_pg,
        nor: nor,
        cliente: cliente,
        iemissao: iemissao,
        femissao: femissao
    };
    //console.log(dados);
    listar(dados);
};

    function listar(dados){
        fetch('/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/consulta/controllers/listar.php',{
            method: 'POST',
            body: JSON.stringify(dados),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            return response.text();
        }).then(function(text){
            document.getElementById('pesquisar').innerHTML = text;
        }).catch(function(error){
            console.log(error);
        })
    };

    function editarOR(id){
        window.location.href = "/owlsoftware/modulos/index.php?pag=OR&id="+id;
        
    };
    function limpar(){
        window.location.href = "/owlsoftware/modulos/index.php?pag=busca_or";
    };

    function clienteB(cod){
        var dados = {
            cod: cod
        };
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bCliente.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            if(text == 'null'){
                alert("Não foi possível localizar cliente com o código informado.");
                document.getElementById("codCli").value = '';
                document.getElementById("nomeCli").value = '';
            }else{
                var cliente = JSON.parse(text);
                cliente.forEach(c => {
                    document.getElementById("codCli").value = c.id;
                    document.getElementById("nomeCli").value = c.nome;
                });
            }
        }).catch(function(error){
            console.log(error);
        });
    }

    function pesquisarCliB(){
        var CPF_CNPJ = document.getElementById("cpfcnpj").value;
        var nome = document.getElementById("nome").value;
        var dados = {
            cpfcnpj: CPF_CNPJ,
            nome: nome
        }
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteModal.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            
            var resultado = document.getElementById("divResultado")
            if(text == 'null'){
                resultado.innerHTML = "Não foi possível localizar clientes cadastrados.";
            }else{
                var clientes = JSON.parse(text);
                resultado.innerHTML = "<table id='tabelaResultado' class='table table-sm'><thead><th>Código</th><th>CPF/CNPJ</th><th>Nome</th><th>#</th></thead>";
                var tabela = document.getElementById("tabelaResultado");
                clientes.forEach(c => {
                    var linha = tabela.insertRow(-1);
                    var col1 = linha.insertCell(0);
                    var col2 = linha.insertCell(1);
                    var col3 = linha.insertCell(2);
                    var col4 = linha.insertCell(3);
                    col1.innerHTML = c.id;
                    col2.innerHTML = c.CPF_CNPJ;
                    col3.innerHTML = c.nome; 
                    col4.innerHTML = "<a onclick='clienteB("+c.id+")' data-toggle='modal' data-target='#modalCliente'><i class='fas fa-check'></i></a>"
                });
            }
        }).catch(function(error){
            console.log(error);
        })
    }