const salvarNF = () => {
    let numPedido = document.getElementById("numPedido").value;
    let emissao = document.getElementById("emissao").value;
    let entrega = document.getElementById("entrega").value;
    let nota = document.getElementById("numNF").value;
    if(numPedido != ''){
        if( entrega !=''){
            let dados = {
                numPedido: numPedido,
                emissao: emissao,
                entrega: entrega,
                nota: nota
            }
            fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/salvarNF.php",{
                method: "POST",
                body: JSON.stringify(dados),
                headers: {'Content-Type':'application/json'}
            }).then((response) => {
                return response.text();
            }).then((text) => {
                console.log(text)
                let resposta = text.split("/");
                alert(resposta[0]);
                window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido&numero="+resposta[1];
            }).catch((error) => {
                alert(error);
            })
        }else{
            alert("Preencha todos os campos");
        }
    }else{
        alert("Informe o pedido que deseja efetuar o faturamento.");
    }
}

