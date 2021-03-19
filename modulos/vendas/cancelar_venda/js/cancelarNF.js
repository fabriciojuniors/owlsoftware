const cancelarNF = () => {
    let nota = document.querySelector("#nNf").value;
    let motivo = document.querySelector("#motivo").value;
    let senha = document.querySelector("#senha").value;

    if (!nota || !motivo || !senha) {
        alert("Preencha todos os campos.");
        return;
    }

    let dados = {
        nota: nota,
        motivo: motivo,
        senha: senha
    }
    fetch("/owlsoftware/modulos/vendas/cancelar_venda/controller/cancelarNF.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: { 'Content-Type': 'application/json' }
    }).then((response) => {
        return response.text();
    }).then((text) => {
        alert(text);
        window.location.reload();
    }).catch((error) => {
        alert(error);
    })

}