function formatarMoeda(i) {
	var v = i.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	i.value = v;
  }
var corpo = document.getElementById("conteudo");
corpo.addEventListener("load", infos());
function infos(){
    fetch("/owlsoftware/modulos/cadastro/condicao_pagamento/cadastro/controllers/data.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        document.getElementById("dt_criacao").value = text;
        document.getElementById("dt_atualizacao").value = text;
    }).catch(function(error){
        console.log(error);
    })
}

function limpar(){
    document.getElementById("codigo").value = '';
    document.getElementById("codigo").removeAttribute("disabled", "");
    document.getElementById("descricao").value = '' ;  
	document.getElementById("id").value = '';
	document.getElementById("parcela_minima").value = '';
    document.getElementById("parcela_maxima").value = '';
    document.getElementById("condicao").value = '';
}

function confirmar(){
    var id = document.getElementById("id").value;
    var cod = document.getElementById("codigo").value;
    var descricao = document.getElementById("descricao").value;
    var criacao = document.getElementById("dt_criacao").value;
    var atualizacao = document.getElementById("dt_atualizacao").value;
    var usuario_criacao = localStorage.getItem("usuario");
    var usuario_atualizacao = localStorage.getItem("usuario");
	var inativo = document.getElementById("inativo").checked;
	var parcela_maxima = document.getElementById("parcela_maxima").value;
	var parcela_minima = document.getElementById("parcela_minima").value;
	parcela_minima = parcela_minima.replace(",","");
	parcela_minima = parcela_minima.replace(".", "");
    parcela_maxima = parcela_maxima.replace(",","");
    parcela_maxima = parcela_maxima.replace(".", "");
    var condicao = document.getElementById("condicao").value;
    parcela_maxima = parcela_maxima/100;
    parcela_minima = parcela_minima/100;
    if(inativo){
        inativo = 1;
    } else{
        inativo = 0;
    }

    if(descricao == ''){
        alert("Preencha todos os campos.");
        document.getElementById("descricao").style.borderColor = "red";
    } else{
        var dados = {
            id: id,
            cod: cod,
            descricao: descricao,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario_criacao: usuario_criacao,
            usuario_atualizacao: usuario_atualizacao,
			inativo: inativo,
			parcela_maxima: parcela_maxima,
            parcela_minima: parcela_minima,
            condicao: condicao
        };
        fetch("/owlsoftware/modulos/cadastro/condicao_pagamento/cadastro/controllers/cadastrar.php", {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            alert(text);
            limpar();
            location.reload();
        }).catch(function(error){
            alert(error);
        })

    }
}

