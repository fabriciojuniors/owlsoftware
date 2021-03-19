const gerarParcelas = () => {
    let forma_pagamento = document.getElementById("sFormaPagto").value;
    let condicao_pagamento = document.getElementById("sCondPagto").value;
    let nota = document.getElementById("numNF").value;
    let dados = {
        forma_pagamento: forma_pagamento,
        condicao_pagamento: condicao_pagamento,
        nota: nota
    };

    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/gerarParcelas.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type':'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        console.log(text);
        let parcelas = JSON.parse(text);
        let dvParcelas = document.getElementById("parcelas");
        dvParcelas.innerHTML = '';
        for (let i = 0; i < parcelas.length; i++) {
            const p = parcelas[i];
            conteudo = dvParcelas.innerHTML;
            dvParcelas.innerHTML = conteudo +  "<div class='row'><div class='col-sm'><input type='date' value='"+p.vencimento+"' class='form-control campos vencimento'   id='vencimento"+i+"'></div><div class='col-sm'><input type='text' value='"+p.valor.toFixed(2).split(".").join(",")+"' onkeypress='mascara(this)' class='form-control campos valor' id='valor"+i+"'></div></div> <br>";
        }
    }).catch((error) => {
        alert(error);
    })
}

const salvarParcelas = () =>{
    let qtd = document.getElementsByClassName("vencimento").length;
    let parcelas = [] ;
    for (let i = 0; i < qtd; i++) {
        let valor = document.getElementById("valor"+i).value.split(".").join("").split(",").join(".");
        let vencimento = document.getElementById("vencimento"+i).value;
        parcelas[i] = {
            valor: valor,
            vencimento: vencimento,
            nota: document.getElementById("numNF").value,
            condicao_pagamento: document.getElementById("sCondPagto").value,
            forma_pagamento: document.getElementById("sFormaPagto").value
        };
    }
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/salvarParcelas.php",{
        method: "POST",
        body: JSON.stringify(parcelas),
        headers: {'Content-Type':'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        
        if(text == 'false'){
            alert("Salvo com sucesso.");
            window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido&numero="+nota+"&aba=3";
        }else{
            alert(text);
        }
    }).catch((error) => {
        alert(error);
    })
}