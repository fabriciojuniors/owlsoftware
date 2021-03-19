if(document.getElementById("numPedido").value == ''){
    document.getElementById("itens-tab").classList.add("disabled");
    document.getElementById("finalizacao-tab").classList.add("disabled");
}else{
    document.getElementById("itens-tab").classList.remove("disabled");
    document.getElementById("finalizacao-tab").classList.remove("disabled");
}

$(document).ready(function($){
    try {
        $('.formatar').mask('000.000.000.000.000,00', {reverse: true});  
    } catch (error) {
        console.log("Não foi possível formatar os campos.");
    }   
    url = window.location.href;
    params = new  URLSearchParams(url);
    pedido = params.get("numero");
    if(pedido != null){
        console.log("oi");
        carregaPedido(pedido);
    }
})

function mascara(i){
    var v = i.value.replace(/\D/g,'');
    v = (v/100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    i.value = v;

}
function pesquisarPedido(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=consulta_pedido";
}
function carregaPedido(pedido){
    var numero = pedido
    var dados = {pedido: numero};
    fetch("/owlsoftware/modulos/vendas/pedido/controller/carregaPedido.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            window.location.href = "/owlsoftware/modulos/index.php?pag=pedido";
        }else{
            var pedido = JSON.parse(text);
            buscarClie(pedido.cliente);
            document.getElementById("tpVenda").value = pedido.tp_venda;
            document.getElementById("numPedido").value = pedido.numero;
            document.getElementById("emissao").value = pedido.dt_emissao;
            document.getElementById("entrega").value = pedido.dt_entrega;
            document.getElementById("itens-tab").classList.remove("disabled");
            document.getElementById("finalizacao-tab").classList.remove("disabled");
            document.getElementById("tpVenda").disabled = true;
            document.getElementById("emissao").disabled = true;
            document.getElementById("codCli").disabled = true;
            document.getElementById("sCondPagto").value = pedido.condicao_pagamento;
            document.getElementById("sFormaPagto").value = pedido.forma_pagamento;
            document.getElementById("obs").value = pedido.observacoes;
            document.getElementById("selecaoCli").disabled = true;
            carregaItemPedido(numero);
        }
    });
}
function carregaItemPedido(pedido){
    var idItemPedido = document.getElementById("idItemPedido").value = '';
    var codProd = document.getElementById("codProd").value= '';
    var quantidade = document.getElementById("quantidade").value= '';
    var precoUnitario = document.getElementById("precoUnitario").value= '';
    var precoTotal = document.getElementById("precoTotal").value= '';
    var desconto = document.getElementById("desconto").value= '';
    var pedido = pedido
    var dados = {pedido: pedido};
    var tableItens = document.getElementById("itensPedido");
    tableItens.innerHTML = '';
    fetch("/owlsoftware/modulos/vendas/pedido/controller/carregaItemPedido.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
       if(text!=''){
           var itens = JSON.parse(text);
           itens.forEach(item => {
            var linha = tableItens.insertRow(-1);
            var colProduto = linha.insertCell(0);
            var colQuantidade = linha.insertCell(1);
            var colprecoUnitario = linha.insertCell(2);
            var coldescontoUnitario = linha.insertCell(3);
            var colprecoTotal = linha.insertCell(4);
            var colEditar = linha.insertCell(5);
            var colExcluir = linha.insertCell(6);
            colProduto.innerHTML = item.descricao;
            colQuantidade.innerHTML = item.quantidade.split(".").join(",");
            colprecoUnitario.innerHTML ="R$"+ item.preco_unitario.split(".").join(",");
            coldescontoUnitario.innerHTML = item.desconto.split(".").join(",") + "%";
            colprecoTotal.innerHTML = "R$"+ item.preco_total.split(".").join(",");
            colEditar.innerHTML = '<a onclick="editarProduto('+item.id+","+item.produto+',\''+item.quantidade+"\','"+item.desconto+'\',\''+item.preco_total+'\',\''+item.preco_unitario+'\')"> <i class="far fa-edit"></i> </a>';
            colExcluir.innerHTML = "<a onclick='excluir("+item.id+","+pedido+")'><i class='fas fa-trash-alt'></i> </a>"
           });
       }else{
           console.log("sem item");
       }
    });
}

function limparItem(){
    document.getElementById("descprod").value = '';
    document.getElementById("codProd").value = '';
    document.getElementById("codProd").disabled = false;
    document.getElementById("idItemPedido").value = '';
    document.getElementById("quantidade").value = '';
    document.getElementById("desconto").value = '';
    document.getElementById("precoUnitario").value ='';
    document.getElementById("precoTotal").value = '';
}
function excluir(id, pedido){
    pedido = pedido;
    dados = {id: id};
    fetch("/owlsoftware/modulos/vendas/pedido/controller/excluirItem.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        alert(text);
        carregaItemPedido(pedido);
    }).catch(function(error){
        console.log(error);
    });
}
function limparPedido(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=pedido";
}
function editarProduto(id, produto, quantidade, desconto, preco_total, preco_unitario){
    buscarProduto(produto);
    document.getElementById("descprod").disabled = true;
    document.getElementById("codProd").disabled = true;
    document.getElementById("idItemPedido").value = id;
    document.getElementById("quantidade").value = quantidade.split(".").join(",");
    document.getElementById("desconto").value = desconto.split(".").join(",");
    document.getElementById("precoUnitario").value = preco_unitario.split(".").join(",");
    document.getElementById("precoTotal").value = preco_total.split(".").join(",");
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

function buscarProduto(cod){
    var dados = {
        cod: cod
    };
    fetch("/owlsoftware/modulos/vendas/pedido/controller/buscaProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Produto não localizado"){
            alert(text);
            document.getElementById("descprod").value ='';
            document.getElementById("codProd").value ='';
            document.getElementById("precoUnitario").value = '';
            document.getElementById("quantidade").value = '';
            document.getElementById("precoTotal").value = '';
            document.getElementById("desconto").value = '';

        }else{
            var prods = JSON.parse(text);
            prods.forEach(prod => {
                var campo = document.getElementById("descprod");
                campo.value = prod.descricao;
                document.getElementById("codProd").value = prod.cod;
                var preco = prod.preco_max;
                if(document.getElementById("idItemPedido").value == ''){
                    document.getElementById("precoUnitario").value = preco.split(".").join(",");
                    calcularValorTotal();
                }
                
            });

        }
    });
    
}

function selecaoProd(){
    var dados = {
        descricao: document.getElementById("s_descricao").value,
        grupo: document.getElementById("g_prod").value,
        tipo: document.getElementById("t_prod").value
    };

    fetch("/owlsoftware/modulos/vendas/pedido/controller/selecaoProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Nenhum produto localizado."){
            alert(text);

        }else{
            document.getElementById("resultado_produtos").innerHTML = text;
        }
    });
    
}

function aplicaDesconto(desconto){
    if(desconto == '' || desconto == '0,00'){
        buscarProduto(document.getElementById("codProd").value);
    }else{
        var valUnitario = parseFloat(document.getElementById("precoUnitario").value.split(",").join(".")).toFixed(2);
        var desconto = parseFloat(document.getElementById("desconto").value.split(",").join(".")).toFixed(2);
        var valorDesconto = (valUnitario*desconto)/100;
        var valorCorrigido = valUnitario - valorDesconto;
        document.getElementById("precoUnitario").value = valorCorrigido.toFixed(2).split(".").join(",");
        calcularValorTotal();    
    }
}

function calcularValorTotal(){
    if(document.getElementById("quantidade").value == ''){
        qtd = 0.00
    }else{
        var qtd = parseFloat(document.getElementById("quantidade").value.split(",").join(".")).toFixed(2);
    }
    
    if(qtd != ''){
        var valUnitario = parseFloat(document.getElementById("precoUnitario").value.split(",").join(".")).toFixed(2);
        var valorFinal  = qtd*valUnitario;
        document.getElementById("precoTotal").value = valorFinal.toFixed(2).split(".").join(",");
    }
}

function validaPedidoGerado(){
    var numPedido = document.getElementById("numPedido").value;
    if(numPedido != ''){
        document.getElementById("itens").classList.remove = "disabled";
    }else{
        alert("Confirme a aba Cadastro para salvar o pedido de venda.");
    }
}

