var corpo = document.getElementById("conteudo");
corpo.addEventListener("load", infos());

function infos(){
    fetch("/owlsoftware/modulos/cadastro/forma_pagamento/cadastro/controller/data.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        document.getElementById("criacao").value = text;
        document.getElementById("atualizacao").value = text;
    }).catch(function(error){
        console.log(error);
    })
}

function limpar(){
    document.getElementById("codigo").value = '';
    document.getElementById("descricao").value = '' ;  
    document.getElementById("id").value = '';
    document.getElementById("inativo").checked = false;
    document.getElementById("avista").checked = false;
}
function confirmar(){
    var id = document.getElementById("id").value;
    var cod = document.getElementById("codigo").value;
    var descricao = document.getElementById("descricao").value;
    var criacao = document.getElementById("criacao").value;
    var atualizacao = document.getElementById("atualizacao").value;
    var usuario_criacao = localStorage.getItem("usuario");
    var usuario_atualizacao = localStorage.getItem("usuario");
    var inativo = document.getElementById("inativo").checked;
    inativo = (inativo) ? 1 : 0;
    var avista = document.getElementById("avista").checked;
    avista = (avista) ? 1 : 0;

    if(descricao == ''){
        alert("Preencha todos os campos.");
        document.getElementById("descricao").style.borderColor = "red";
    } else{
        var dados = {
            id: id,
            cod: cod,
            descricao: descricao,
            avista: avista,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario_criacao: usuario_criacao,
            usuario_atualizacao: usuario_atualizacao,
            inativo: inativo
        };
        fetch("/owlsoftware/modulos/cadastro/forma_pagamento/cadastro/controller/cadastrar.php", {
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

