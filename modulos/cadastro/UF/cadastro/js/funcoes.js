var corpo = document.getElementById("conteudo");
window.addEventListener("load", infos());

function infos(){
      fetch("/owlsoftware/modulos/cadastro/UF/cadastro/controller/data.php")
      .then(function(response){
          return response.text();
      }).then(function(text){
          document.getElementById("dt_criacao").value = text;
          document.getElementById("dt_atualizacao").value = text;
      }).catch(function(error){
          console.log(error);
      });

    fetch("/owlsoftware/modulos/cadastro/UF/cadastro/controller/info.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        result = JSON.parse(text);
        result.forEach(pais => {
            var x = document.getElementById("selectpais");
            var option = document.createElement("option");
            option.value = pais.id;
            option.text = pais.nome;
            x.add(option);
        });
    }).catch(function(error){
        console.log(error);
    })
    
}

function confirmar(){
    var id = document.getElementById("id").value;
    var cod = document.getElementById("codigo").value;
    var descricao = document.getElementById("nome").value;
    var sigla = document.getElementById("sigla").value.toUpperCase();
    var pais = document.getElementById("selectpais").value;
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
    } else if (sigla == ''){
        alert("Preencha todos os campos.");
        document.getElementById("sigla").style.borderColor = "red";
    } else if(pais == "#"){
        alert("Preencha todos os campos.");
        document.getElementById("pais").style.borderColor = "red";
    } else{
        var dados = {
            id: id,
            cod: cod,
            descricao: descricao,
            sigla: sigla,
            pais: pais,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario_criacao: usuario_criacao,
            usuario_atualizacao: usuario_atualizacao,
            inativo: inativo
        };
        console.log(dados);
        fetch("/owlsoftware/modulos/cadastro/UF/cadastro/controller/cadastrar.php", {
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

function limpar(){
    var id = document.getElementById("id").value ='';
    var cod = document.getElementById("codigo").value ='';
    var descricao = document.getElementById("nome").value = '';
    var sigla = document.getElementById("sigla").value = '';
    var pais = document.getElementById("pais").value = '';
}
