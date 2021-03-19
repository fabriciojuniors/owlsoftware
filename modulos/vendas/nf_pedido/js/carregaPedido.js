const carregaPedido = (pedido) => {
    if(pedido == ''){
        document.getElementById("numPedido").value = '';
        document.getElementById("codCli").value = '';
        document.getElementById("nomeCli").value = '';
        document.getElementById("tpVenda").value = '#';
        document.getElementById("emissao").value = '';
        document.getElementById("entrega").value = '';
        document.getElementById("sFormaPagto").value = '#';
        document.getElementById("sCondPagto").value = '#';
        document.getElementById("itens-tab").classList.add("disabled");
        document.getElementById("financeiro-tab").classList.add("disabled");
        document.getElementById("finalizacao-tab").classList.add("disabled");
    }
    let nota = document.getElementById("numNF").value;
    console.log(nota + "oi");
    let dados = {pedido: pedido, nota : nota};
    console.log(dados);
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/carregaPedido.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
        if(text == "0"){
            document.getElementById("numPedido").value = '';
            document.getElementById("codCli").value = '';
            document.getElementById("nomeCli").value = '';
            document.getElementById("tpVenda").value = '#';
            document.getElementById("emissao").value = '';
            document.getElementById("entrega").value = '';
            document.getElementById("sFormaPagto").value = '#';
            document.getElementById("sCondPagto").value = '#';
            document.getElementById("itens-tab").classList.add("disabled");
            document.getElementById("financeiro-tab").classList.add("disabled");
            document.getElementById("finalizacao-tab").classList.add("disabled");
            alert("Não foi possível localizar o pedido informado ou o mesmo já foi faturado.");
        }else{
            let pedido = JSON.parse(text);
            if(pedido.saldo > 0){
                document.getElementById("numPedido").value = pedido.numero;
                buscarClie(pedido.cliente);
                document.getElementById("tpVenda").value = pedido.tp_venda;
                document.getElementById("entrega").value = pedido.dt_entrega;
                document.getElementById("sFormaPagto").value = pedido.forma_pagamento;
                document.getElementById("sCondPagto").value = pedido.condicao_pagamento;
                carregaItem(pedido.numero);
            }else{alert("Não foi possível localizar o pedido informado ou o mesmo já foi faturado.");}

        }
    }).catch(function(error){
        //console.log(error);
    });
}

const carregaPedidoFat = (pedido) => {
    if(pedido == ''){
        document.getElementById("numPedido").value = '';
        document.getElementById("codCli").value = '';
        document.getElementById("nomeCli").value = '';
        document.getElementById("tpVenda").value = '#';
        document.getElementById("emissao").value = '';
        document.getElementById("entrega").value = '';
        document.getElementById("sFormaPagto").value = '#';
        document.getElementById("sCondPagto").value = '#';
        document.getElementById("itens-tab").classList.add("disabled");
        document.getElementById("financeiro-tab").classList.add("disabled");
        document.getElementById("finalizacao-tab").classList.add("disabled");
    }
    let nota = document.getElementById("numNF").value;
    let dados = {pedido: pedido, nota : nota};
    console.log(dados);
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/carregaPedidoFAT.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
        if(text == "0"){
            document.getElementById("numPedido").value = '';
            document.getElementById("codCli").value = '';
            document.getElementById("nomeCli").value = '';
            document.getElementById("tpVenda").value = '#';
            document.getElementById("emissao").value = '';
            document.getElementById("entrega").value = '';
            document.getElementById("sFormaPagto").value = '#';
            document.getElementById("sCondPagto").value = '#';
            document.getElementById("itens-tab").classList.add("disabled");
            document.getElementById("financeiro-tab").classList.add("disabled");
            document.getElementById("finalizacao-tab").classList.add("disabled");
            alert("Não foi possível localizar o pedido informado.");
        }else{
            let pedido = JSON.parse(text);
            document.getElementById("numPedido").value = pedido.numero;
            buscarClie(pedido.cliente);
            document.getElementById("tpVenda").value = pedido.tp_venda;
            document.getElementById("emissao").value = pedido.emissao;
            document.getElementById("entrega").value = pedido.entrega;
            document.getElementById("sFormaPagto").value = pedido.forma_pagamento;
            document.getElementById("sCondPagto").value = pedido.condicao_pagamento;
            carregaItem(pedido.numero);
        }
    }).catch(function(error){
        //console.log(error);
    });
}

const carregaItem = (pedido) => {
    let dados = {pedido: pedido, nota: document.getElementById("numNF").value};
    var tabela = document.getElementById("tbItens");
    tabela.innerHTML = '';
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/carregaItemPedido.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        //console.log(text);
        itens = JSON.parse(text);
            for (let j = 0; j < itens.length; j++) {
                const i = itens[j];
                let linha = tabela.insertRow(-1);
                let colProduto = linha.insertCell(0);
                let colQtd = linha.insertCell(1);
                let colQtdSaldo = linha.insertCell(2);
                let colEstDisp = linha.insertCell(3);
                let colValUnit = linha.insertCell(4);
                let colDesconto = linha.insertCell(5);
                let colValTotal = linha.insertCell(6);
                let colQtdFaturar = linha.insertCell(7);
                let colFaturar = linha.insertCell(8);
                colProduto.innerHTML = i.produto + " - " + i.descricao;
                colProduto.id = "produto"+j;
                colQtd.innerHTML = i.quantidade.split(".").join(",");
                colQtd.id = "qtd"+j;
                colQtdSaldo.innerHTML = i.quantidade_saldo.split(".").join(",");
                colEstDisp.innerHTML = i.saldo.split(".").join(",");
                colValUnit.id = "valUnit"+j
                colValUnit.innerHTML = "R$"+i.preco_unitario.split(".").join(",");
                colDesconto.innerHTML = "%"+i.desconto.split(".").join(",");
                colValTotal.innerHTML = "R$"+i.preco_total.split(".").join(",");
                let desativado = '';
                if(i.existe == '1'){
                    desativado = "disabled='disabled' checked";
                }
                if(parseFloat(i.quantidade_saldo) > parseFloat(i.saldo)){
                    console.log("saldo " +i.quantidade_saldo);
                    console.log("disp " +i.saldo);
                    desativado = "disabled='disabled' title='Estoque disponível inferior ao saldo do pedido.'";
                }
                colQtdFaturar.innerHTML = "<input  style='width: 80%; ' "+desativado+" type='text' class='campos form-control' onkeypress='mascara(this)' value='"+i.quantidade_saldo.split(".").join(",")+"' id='qtdFaturar"+j+"'>";
                colFaturar.innerHTML = "<input type='checkbox' "+desativado+" id='faturar"+j+"'>"
                
            }
    }).catch(function(error){
        //console.log(error);
    });
}