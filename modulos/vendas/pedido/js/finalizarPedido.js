function finalizarPedido(){
    var pedido = document.getElementById("numPedido").value;
    var condPag = document.getElementById("sCondPagto").value;
    var formaPag = document.getElementById("sFormaPagto").value;
    var obs = document.getElementById("obs").value;
    if(condPag == '#' || formaPag == '#'){
        alert("Preencha todos os campos");
    }else{
        var dados = {
            pedido: pedido,
            condPag: condPag,
            formaPag: formaPag,
            obs: obs
        }
        fetch("/owlsoftware/modulos/vendas/pedido/controller/finalizarPedido.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            alert(text);
            window.location.href = "/owlsoftware/modulos/index.php?pag=pedido";
        });
    }
}