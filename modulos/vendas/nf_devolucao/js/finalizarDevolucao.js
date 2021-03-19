const finalizarDevolucao = () =>{
    let dados = {
        nota: document.getElementById("numNF").value
    };
    fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/finalizarDevolucao.php',{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type' : 'application/json'}
    }).then((response)=>{
        return response.text();
    }).then((text) =>{
        if(!text == ''){
            alert(text);
        }else{
            window.location.href = "/owlsoftware/modulos/index.php?pag=nf_devolucao";
        }
    }).catch((error)=>{
        alert(error);
    })
}