const salvarNF = () => {
    let nomeArquivo = document.querySelector("#nomeArquivo").value;
    let chave = document.querySelector("#chave").value;
    let numero = document.querySelector("#numero").value;
    let tp_entrada = document.querySelector("#tp_entrada").value;
    let fornecedor = document.querySelector("#codCli").value;
    let emissao = document.querySelector("#emissao").value;
    let entrada = document.querySelector("#entrada").value;
    let idNota = document.querySelector("#idNota").value;

    if (!numero || tp_entrada == "#" || !fornecedor || !emissao || !entrada) {
        alert("Preencha todos os campos.");
        return;
    }

    let dados = {
        nomeArquivo: nomeArquivo,
        chave: chave,
        numero: numero,
        tp_entrada: tp_entrada,
        fornecedor: fornecedor,
        emissao: emissao,
        entrada: entrada,
        idNota: idNota
    }

    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/salvarNF.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        if(text == 1){
            alert("Salvo com sucesso");
            window.location.href = "/owlsoftware/modulos/index.php?pag=entrada_xml&n=" + numero;
            return;
        }
        alert(text);
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}