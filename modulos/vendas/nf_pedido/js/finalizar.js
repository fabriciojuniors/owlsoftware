const finalizarNF = () =>{
    let nota = document.querySelector("#numNF").value;
    let dados = {nota: nota};

    fetch("/owlsoftware/modulos/vendas/nf_pedido/controller/finalizarNF.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type':'application/json'}
    }).then((response) => {
        return response.text();
    }).then((text) => {
        console.log(text);
        alert(text);
        window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido";
    }).catch((error) => {
        alert(error);
    })
}