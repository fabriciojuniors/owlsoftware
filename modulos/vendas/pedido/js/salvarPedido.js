function salvarPedido(){
    var tpVenda = document.getElementById("tpVenda").value;
    var codCli = document.getElementById("codCli").value;
    var emissao = document.getElementById("emissao").value;
    var entrega = document.getElementById("entrega").value;
    var usuario = localStorage.getItem("id");
    var numPedido = document.getElementById("numPedido").value;

    if(tpVenda == '#' || codCli == '' || emissao == '' || entrega == ''){
        alert("Preencha todos os campos.");
        if(tpVenda == '#'){
            document.getElementById("tpVenda").style.borderColor =  'red';
        }
        if(codCli == ''){
            document.getElementById("codCli").style.borderColor =  'red';
        }
        if(emissao == ''){
            document.getElementById("emissao").style.borderColor = 'red';
        }
        if(entrega == ''){
            document.getElementById("entrega").style.borderColor = 'red';
        }
    }else{
        var dados = {
            numPedido: numPedido,
            tpVenda: tpVenda,
            codCli: codCli,
            emissao: emissao,
            entrega: entrega,
            usuario: usuario
        }

        fetch("/owlsoftware/modulos/vendas/pedido/controller/salvarPedido.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            var msg = text;
            msg = msg.split("/");
            document.getElementById("numPedido").value = msg[1];
            document.getElementById("itens-tab").classList.remove("disabled");
            document.getElementById("tpVenda").disabled = true;
            document.getElementById("emissao").disabled = true;
            document.getElementById("codCli").disabled = true;
            document.getElementById("selecaoCli").disabled = true;
            alert(msg[0]);
            window.location.href = "/owlsoftware/modulos/index.php?pag=pedido&numero="+msg[1];
        });
    }
}