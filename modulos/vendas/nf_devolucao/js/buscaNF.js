const buscaNFDev = (nf) =>{
    if(nf != ''){
        let dados = {nf: nf};
        fetch('/owlsoftware/modulos/vendas/nf_devolucao/controllers/buscaNF.php',{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type' : 'application/json'}
        }).then((response)=>{
            return response.text();
        }).then((text) =>{
            if(text == '0'){
                alert("Nota não encontrada ou a mesma já foi devolvida.");
            }
            
        }).catch((error)=>{
            alert(error);
        })
    }else{
        alert("Preencha todos os campos.");
    }
}