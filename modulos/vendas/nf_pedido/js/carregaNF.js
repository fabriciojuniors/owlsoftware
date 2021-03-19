const carregaNF = (nota) =>{
    let dados = {nota: nota}
    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/carregaNF.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type':'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        let nota = JSON.parse(text);
        carregaPedidoFat(nota[0]);
        document.getElementById("numPedido").readOnly = true;
        document.getElementById("numNF").value = nota[2];
        document.getElementById("emissao").value = nota[4];
        document.getElementById("emissao").readOnly = true;
        document.getElementById("entrega").value = nota[5];
        document.getElementById("itens-tab").classList.remove("disabled");
        document.getElementById("financeiro-tab").classList.remove("disabled");
        document.getElementById("finalizacao-tab").classList.remove("disabled");
        carregaItemNF();
    }).catch((error) => {
        alert(error);
    })
}