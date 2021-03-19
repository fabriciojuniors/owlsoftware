const finalizarEntrada = ()=>{
    let dados = {nota: document.querySelector("#numero").value};

    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/finalizarNF.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        if(text == 1){
            alert("Salvo com sucesso");
            window.location.href = "/owlsoftware/modulos/index.php?pag=entrada_xml";
            return;
        }
        alert(text);
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}