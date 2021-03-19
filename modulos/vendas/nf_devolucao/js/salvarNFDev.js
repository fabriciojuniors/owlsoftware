const salvarNFDev = () =>{
    let nfDev = document.getElementById("nfDev").value;
    let tpDev = document.getElementById("tp_devolucao").value;
    let emissao = document.getElementById("emissao").value;
    if(nfDev == '' || tpDev == '#' || emissao == ''){
        alert("Preencha todos os campos.");
    }else{
        let dados = {
            nfDev: nfDev,
            tpDev: tpDev,
            emissao: emissao
        }

        fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/salvarNFDev.php',{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type' : 'application/json'}
        }).then((response)=>{
            return response.text();
        }).then((text) =>{
            let nota = text.split("/");
            if(parseInt(nota[1])){
                window.location.href = "/owlsoftware/modulos/index.php?pag=nf_devolucao&numero="+nota[1];
            }else{
                alert(text);
            }
        }).catch((error)=>{
            alert(error);
        })
    }
}