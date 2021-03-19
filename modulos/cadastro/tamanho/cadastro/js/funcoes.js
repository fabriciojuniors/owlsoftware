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
    fetch("/owlsoftware/modulos/cadastro/tamanho/cadastro/controllers/data.php")
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
    document.getElementById("descricao").value = '' ;  
	document.getElementById("id").value = '';
	document.getElementById("largura").value = '0,00';
    document.getElementById("altura").value = '0,00';
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
	var altura = document.getElementById("altura").value;
	var largura = document.getElementById("largura").value;
	largura = largura.replace(",","");
	largura = largura.replace(".", "");
    altura = altura.replace(",","");
    altura = altura.replace(".", "");
    altura = altura/100;
    largura = largura/100;
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
			altura: altura,
            largura: largura
        };
        fetch("/owlsoftware/modulos/cadastro/tamanho/cadastro/controllers/cadastrar.php", {
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

