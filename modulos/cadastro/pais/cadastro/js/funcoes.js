var corpo = document.getElementById("conteudo");
corpo.addEventListener("load", infos());

function infos(){
    fetch("/owlsoftware/modulos/cadastro/pais/cadastro/controller/data.php")
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
    document.getElementById("nome").value = '' ;  
    document.getElementById("id").value = '';
    document.getElementById("sigla").value = '';
}
function confirmar(){
    var id = document.getElementById("id").value;
    var cod = document.getElementById("codigo").value;
    var descricao = document.getElementById("nome").value;
    var sigla = document.getElementById("sigla").value.toUpperCase();
    var criacao = document.getElementById("dt_criacao").value;
    var atualizacao = document.getElementById("dt_atualizacao").value;
    var usuario_criacao = localStorage.getItem("usuario");
    var usuario_atualizacao = localStorage.getItem("usuario");
    var inativo = document.getElementById("inativo").checked;
    
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
            sigla: sigla,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario_criacao: usuario_criacao,
            usuario_atualizacao: usuario_atualizacao,
            inativo: inativo
        };
        fetch("/owlsoftware/modulos/cadastro/pais/cadastro/controller/cadastrar.php", {
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

