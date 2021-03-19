$(document).ready(function($){
    url = window.location.href;
    params = new  URLSearchParams(url);
    nota = params.get("numero");
    //aba = params.get("aba");
    if(nota != null){
        //console.log("oi");
        carregaNFDev(nota);
    }
    /*if(aba == "2"){
        setTimeout(() => {
            document.getElementById("itens-tab").click();    
        }, 100);
        
    }else if(aba == "3"){
        setTimeout(() => {
            document.getElementById("financeiro-tab").click();    
        }, 100);
        
    }*/
})

const carregaNFDev = (num) =>{
    let dados = {nota: num};
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/carregaNFDev.php',{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
        if(text == "0"){
            alert("Não foi possível carregar a nota de devolução.");
            window.location.href = "/owlsoftware/modulos/index.php?pag=nf_devolucao";
        }else{
            let nota = JSON.parse(text);
            document.getElementById("nfDev").value = nota.devolvida;
            document.getElementById("nfDev").disabled = true;
            document.getElementById("tp_devolucao").value = nota.tp_venda;
            document.getElementById("tp_devolucao").disabled = true;
            document.getElementById("numNF").value = num;
            document.getElementById("numNF").disabled = true;
            document.getElementById("tab-itens").classList.remove("disabled");
            //document.getElementById("tab-finalizar").classList.remove("disabled");

        }
    }).catch((error)=>{
        alert(error);
    })
}

const carregaItens = () =>{
    carregarItensAdicionado();
    let notaDevolvida = document.getElementById("nfDev").value;
    let nota = document.getElementById("numNF").value;
    let dados = {notaDevolvida: notaDevolvida,nota: nota};
    let corpo = document.getElementById("cItensDevolvido");
    corpo.innerHTML = '';
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/carregaItens.php',{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
       try {
            let nota = JSON.parse(text);
            for (let i = 0; i < nota.length; i++) {
                const n = nota[i];
                let linha = corpo.insertRow(-1);
                let col1 = linha.insertCell(0);
                let col2 = linha.insertCell(1);
                let col3 = linha.insertCell(2);
                let col4 = linha.insertCell(3);
 
                col1.innerHTML = n.id + " - "+n.descricao;
                col1.id = "produto"+i;
                col2.innerHTML = n.quantidade_faturar.split(".").join(",");
                col2.id = "qtd_faturar"+i;
                col3.innerHTML = "<input type='text' class='form-control campos' id='quantidade"+i+"' value='"+n.quantidade_faturar.split(".").join(",")+"' style='width: 80px'>";
                let ativo = (n.adicionado === "1") ? "disabled checked" : "";
                col4.innerHTML = "<input type='checkbox' "+ativo+" id='devolver"+i+"'>";
            }
       } catch (error) {
           console.log(text);
            alert(text);
       }
    }).catch((error)=>{
        alert(error);
    })
}