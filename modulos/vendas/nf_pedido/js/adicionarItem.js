const adicionarItens = () =>{
    let tabela = document.getElementById("tbItens");
    let linhas = tabela.getElementsByTagName("tr");
    let qtd = linhas.length;
    let dados = [];
    for (let i = 0; i < qtd; i++) {
       let checkFaturar = "faturar"+i;
       let qtdFaturarE = "qtdFaturar"+i;
       let valUnit = "valUnit"+i;
       let faturar = document.getElementById(checkFaturar).checked;
       let produto = document.getElementById("produto"+i);
       let inativo = document.getElementById(checkFaturar).disabled;

       if(faturar && !inativo){
            produto = produto.innerHTML.substr(0,1).trim();
            qtdFaturar = parseFloat(document.getElementById(qtdFaturarE).value.split(",").join(".")).toFixed(2);
            valUnit = parseFloat(document.getElementById(valUnit).innerHTML.split("R$").join("").split(",").join(".")).toFixed(2);
            valTotal = (qtdFaturar * valUnit).toFixed(2);
            dados[i] = {
                nf: document.getElementById("numNF").value,
                produto: produto,
                qtdFaturar: qtdFaturar,
                valUnit: valUnit,
                valTotal: valTotal
            }                
                
            document.getElementById(checkFaturar).disabled = "true";
            document.getElementById(qtdFaturarE).disabled = "true";
            
        } 
    }

    //Salvar no php
    let nota = document.getElementById("numNF").value;
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/salvarItem.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        console.log(text);
        let resposta = text;
        if(resposta != 1){
            alert(text);
        } 
        window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido&numero="+nota+"&aba=2"
    }).catch((error)=>{
        alert(error);
    })
    
}

const carregaItemNF = () =>{
    let dados = {nf: document.getElementById("numNF").value};
    let tabela = document.getElementById("itensAdded");
    tabela.innerHTML = '';
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/carregaItemNF.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        if(text != '1'){
            let itens = JSON.parse(text);
            for (let i = 0; i < itens.length; i++) {
                const item = itens[i];
                let linha = tabela.insertRow(-1);
                let colProduto = linha.insertCell(0);
                let colQtdFaturar = linha.insertCell(1);
                let colValUnit = linha.insertCell(2);
                let colValTotal = linha.insertCell(3);
                let colExcluir = linha.insertCell(4);
                colProduto.innerHTML = item.produto + " - " + item.descricao;
                colQtdFaturar.innerHTML = item.quantidade_faturar.split(".").join(",");
                colValUnit.innerHTML = item.valor_unitario.split(".").join(",");
                colValTotal.innerHTML = item.valor_total.split(".").join(",");
                colExcluir.innerHTML = "<a  onclick='excluirItemNF("+item.id+")'><input type='hidden' value="+item.id+" id='excluir"+i+"'> <i style='color: blue;' class='fas fa-trash-alt'></i></a>";
            }
        }

    }).catch((error)=>{
        alert(error);
    })
}
const excluirTodos = () =>{
    let nota = document.getElementById("numNF").value;
    let tabela = document.getElementById("itensAddedT");
    let linhas = tabela.getElementsByTagName("tr");
    
    for (let i = 0; i < (linhas.length-1); i++) {
        let excluir = "excluir"+i;
        excluir = document.getElementById(excluir).value;
        //console.log(excluir);
        excluirItemNFT(excluir);
    }
    alert("Excluído com sucesso.");
    window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido&numero="+nota+"&aba=2"
}
const excluirItemNFT = (item) => {
    let nota = document.getElementById("numNF").value;
    dados = {
        item: item,
        nota: nota
    };
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/excluirItem.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        //console.log(text);
    }).catch((error)=>{
        //alert(error);
    })
}
const excluirItemNF = (item) => {
    let nota = document.getElementById("numNF").value;
    dados = {
        item: item,
        nota: nota
    };
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/excluirItem.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        alert(text);
        carregaItemNF();
        carregaItem(document.getElementById("numPedido").value);
    }).catch((error)=>{
        alert(error);
    })
}