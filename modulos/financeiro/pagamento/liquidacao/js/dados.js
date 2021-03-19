var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());

function carregaDados(){
    carregaConta();
    carregaTPMovto();
    validaFiltro();
}

function carregaTPMovto(){
    fetch("/owlsoftware/modulos/financeiro/pagamento/liquidacao/controller/bTPMovto.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível carregar conta bancária.");
        }else{
            var condicao = JSON.parse(text);
            var select = document.getElementById("stpmovto");
            condicao.forEach(c => {
                var opt = document.createElement("option");
                opt.value = c[0];
                opt.text = c[1];
                select.append(opt);
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}

function carregaConta(){
    fetch("/owlsoftware/modulos/financeiro/pagamento/ordem_pagamento/controller/bConta.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível carregar conta bancária.");
        }else{
            var condicao = JSON.parse(text);
            var select = document.getElementById("sconta");
            condicao.forEach(c => {
                var opt = document.createElement("option");
                opt.value = c[1];
                opt.text = c[0] + " - (AG: " + c[2] + ", CONTA: " + c[3] + ")";
                select.append(opt);
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}