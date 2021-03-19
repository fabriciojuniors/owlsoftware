const gerarParcelas = () => {
    let condicao = document.querySelector("#condPag").value;
    if (condicao == "#") {
        let corpo = document.querySelector("#tbParcelas");
        corpo.innerHTML = "";
        return;
    }

    let dados = { condicao: condicao, nota: document.querySelector("#numero").value };
    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/gerarParcelas.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        try {
            let parcelas = JSON.parse(text);
            let corpo = document.querySelector("#tbParcelas");
            corpo.innerHTML = "";
            for (let i = 0; i < parcelas.length; i++) {
                const p = parcelas[i];
                let linha = corpo.insertRow(-1);
                let col1 = linha.insertCell(0);
                let col2 = linha.insertCell(1);
                let col3 = linha.insertCell(2);

                col1.innerHTML = i + 1;
                col2.innerHTML = p.vencimento;
                col3.innerHTML = "R$" + p.valor;
            }


        } catch (error) {
            let corpo = document.querySelector("#tbParcelas");
            corpo.innerHTML = "";
        }
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}

const salvarParcelas = () =>{
    let condicao = document.querySelector("#condPag").value;
    let forma = document.querySelector("#formaPag").value;
    if (forma == "#" ||condicao == "#") {
        alert("Preencha todos os campos");
        return;
    } 

    let dados = {condicao: condicao, forma:forma, nota: document.querySelector("#numero").value};

    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/salvarParcelas.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        alert(text);
        if(text == "Salvo com sucesso"){document.querySelector("#btn-finalizar").classList.remove("disabled"); document.querySelector("#btn-finalizar").removeAttribute('title')}
    }).catch((e) => {
        alert("Não foi possível se conectar ao servidor. \n" + e);
    })
}