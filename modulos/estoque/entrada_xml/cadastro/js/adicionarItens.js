const adicionarItens = () => {
    let corpo = document.getElementById("corpoItensXML");
    let linhas = corpo.getElementsByTagName("tr");
    let dados = [];

    for (let i = 1; i <= linhas.length; i++) {
        let id = "#movimentar" + i;
        let check = document.querySelector(id);
        if (check.checked && document.querySelector("#codProd" + i).value != '' && document.querySelector("#qtdmov" + i).value != '') {
            dados.push({
                nota: document.querySelector("#numero").value,
                produto: document.querySelector("#codProd" + i).value,
                codXML: document.querySelector("#codProdXML"+i).value,
                qtd: document.querySelector("#qtdmov" + i).value,
                valor: document.querySelector("#valUnit" + i).value
            })
            check.disabled = "true";
        } else { alert("Preencha todos os campos. "); return; }
    }

    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/adicionarItens.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        alert(text);
        window.location.reload();
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}