const carregaItens = () => {
    let dados = { nota: document.querySelector("#numero").value };
    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/carregaItens.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        if (!text == "0") {
            let produtos = JSON.parse(text);
            for (let i = 0; i < produtos.length; i++) {
                const p = produtos[i];
                for(let j = 1; j< parseInt(document.querySelector("#qtdTotalItem").value); j++){
                    if(document.querySelector("#codProdXML"+j).value == p.codXML){
                        buscarProduto(p.produto, (j-1));
                        document.querySelector("#qtdmov"+j).value == p.quantidade;
                        document.querySelector("#movimentar"+j).checked = true;
                    }
                }
            }
        }
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}