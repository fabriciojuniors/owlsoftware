var qnt_result_pg = 6; //quantidade de registro por página
var pagina = 1; //página inicial
var corpo = document.getElementById("conteudo");
window.addEventListener("load", pesquisarPedido(pagina, 8, '', '', '', '', ''));
function pesquisarPedido(pagina, qnt_result_pg, pedido, cliente, tpVenda, inicio, fim){
    if(tpVenda == undefined){
        tpVenda = document.getElementById("tpVenda").value;
    }
    if(cliente == undefined){
        cliente = document.getElementById("codCli").value;
    }
    if(pedido == undefined){
        pedido = document.getElementById("numPedido").value;
    }
    if(inicio == undefined){
        inicio = document.getElementById("iemissao").value;
    }
    if(fim == undefined){
        fim = document.getElementById("femissao").value;
    }
    dados = {pagina: pagina, 
        qnt_result_pg: qnt_result_pg,
        pedido: pedido,
        cliente: cliente,
        tpVenda: tpVenda,
        inicio: inicio,
        fim: fim
    };
    listar(dados);
};

    function listar(dados){
        console.log(dados);
        fetch('/owlsoftware/modulos/vendas/pedido/consulta/controllers/listar.php',{
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

    function editarPedido(pedido){
        window.location.href = "/owlsoftware/modulos/index.php?pag=pedido&numero="+pedido;
    }

    function buscarClie(cod){
        var dados = {
            cod: cod
        };
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteE.php",{
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
    function pesquisarCli(){
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
                    col4.innerHTML = "<a onclick='buscarClie("+c.id+")' data-toggle='modal' data-target='#modalCliente'><i class='fas fa-check'></i></a>"
                });
            }
        }).catch(function(error){
            console.log(error);
        })
    }