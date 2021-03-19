function adicionarItem(){
    var idItemPedido = document.getElementById("idItemPedido").value;
    var numPedido = document.getElementById("numPedido").value;
    var codProd = document.getElementById("codProd").value;
    var quantidade = document.getElementById("quantidade").value;
    var precoUnitario = document.getElementById("precoUnitario").value;
    var precoTotal = document.getElementById("precoTotal").value;
    var desconto = document.getElementById("desconto").value;
    desconto = (desconto =='') ? desconto = '0,00' : desconto = desconto;

        if(numPedido == '' || codProd == '' || quantidade == '' || precoUnitario == '' || precoTotal == ''){
            alert("Preencha todos os campos");
        }else{
            desconto = (desconto == '') ? desconto = 0.00 : desconto = desconto;
            quantidade = quantidade.split(".").join("");
            quantidade = quantidade.split(",").join(".");
            precoTotal = precoTotal.split(".").join("");
            precoTotal = precoTotal.split(",").join(".");
            precoUnitario = precoUnitario.split(".").join("");
            precoUnitario = precoUnitario.split(",").join(".");
            desconto = desconto.split(".").join("");
            desconto = desconto.split(",").join(".");
            var dados = {
                idItemPedido: idItemPedido,
                numPedido : numPedido,
                codProd: codProd,
                quantidade: quantidade,
                precoUnitario: precoUnitario,
                precoTotal: precoTotal,
                desconto: desconto
            };
            fetch("/owlsoftware/modulos/vendas/pedido/controller/adicionarItem.php",{
                method: "POST",
                body: JSON.stringify(dados),
                headers: {'Content-Type': 'application/json'}
            }).then(function(response){
                return response.text();
            }).then(function(text){
                if(text != '1'){
                    alert(text);
                }
                carregaItemPedido(numPedido);
            });
        }
    }
