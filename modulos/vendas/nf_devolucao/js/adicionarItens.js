const adicionarItens = () =>{
    let table = document.getElementById("tItensDevolvido");
    let linhas = table.getElementsByTagName("tr");
    let qtd = linhas.length-1;
    let itens = {};
    for (let i = 0; i < qtd; i++) {
        let check = document.getElementById("devolver"+i);
        if(check.checked && !check.disabled){
            let item = document.getElementById("produto"+i).innerHTML;
            item = item.split("-");
            item = item[0];
            item = item.trim();
            let qtd_faturar = parseFloat(document.getElementById("qtd_faturar"+i).innerHTML.split(",").join("."));
            let qtd_devolver = parseFloat(document.getElementById("quantidade"+i).value.split(",").join("."));
            if(qtd_devolver<=qtd_faturar){
                itens[i] = {
                    produto: item,
                    qtd: qtd_devolver,
                    nota: document.getElementById("numNF").value,
                    nfDev: document.getElementById("nfDev").value
                };
            }else{
                alert("Quantidade a devolver maior que quantidade faturada.");
            }

        }
    }
    salvarItens(itens);
}

const salvarItens = (itens) =>{
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/salvarItens.php',{
        method: "POST",
        body: JSON.stringify(itens),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
        if(text == ''){
            alert("Adicionado com sucesso.");carregaItens();
        }else{
            alert(text);
        } 
    }).catch((error)=>{
        alert(error);
    })
}

const carregarItensAdicionado = () =>{
    let dados = {nota: document.getElementById("numNF").value}
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/carregarItensAdicionado.php',{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
            try {
                let itens = JSON.parse(text);
                let corpo = document.getElementById("bItensAdicionados");
                corpo.innerHTML = '';
                itens.forEach(i => {
                    let linha = corpo.insertRow(-1);
                    let col1 = linha.insertCell(0);
                    let col2 = linha.insertCell(1);
                    let col3 = linha.insertCell(2);
                    let col4 = linha.insertCell(3);
                    col1.innerHTML = i.produto;
                    col3.innerHTML = i.devolvida;
                    col2.innerHTML = i.faturada;
                    col4.innerHTML = "<a onclick='excluirItem("+i.id+")'><i style='color: blue' class='fas fa-trash-alt'></i></a>";
                });
            } catch (error) {
                let corpo = document.getElementById("bItensAdicionados");
                corpo.innerHTML = '';
            }

    }).catch((error)=>{
        alert(error);
    })
}

const excluirItem = (item) =>{
    let itens = {item: item};
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/excluirItem.php',{
        method: "POST",
        body: JSON.stringify(itens),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
        if(!text == ''){
            alert(text);
        }else{
            carregaItens();
        }
    }).catch((error)=>{
        alert(error);
    })
}