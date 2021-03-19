var corpo = document.getElementById("conteudo");
window.addEventListener("load", infos());

function infos(){


    fetch("/owlsoftware/modulos/cadastro/tipo_venda/cadastro/controller/carregaOrigemMovto.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        result = JSON.parse(text);
        result.forEach(origem => {
            var x = document.getElementById("origemmovto");
            var option = document.createElement("option");
            option.value = origem.id;
            option.text = origem.descricao;
            x.add(option);
        });
    }).catch(function(error){
        console.log(error);
    })
    fetch("/owlsoftware/modulos/cadastro/tipo_venda/cadastro/controller/carregaTipoMovto.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        result = JSON.parse(text);
        result.forEach(tipomovto => {
            var x = document.getElementById("tipomovto");
            var option = document.createElement("option");
            option.value = tipomovto.id;
            option.text = tipomovto.descricao;
            x.add(option);
        });
    }).catch(function(error){
        console.log(error);
    })
    
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
    inativo = (inativo) ? 1 : 0;
    var financeiro = document.getElementById("financeiro").checked;
    financeiro = (financeiro) ? 1 : 0;
    var devolucao = document.getElementById("devolucao").checked;
    devolucao = (devolucao) ? 1 : 0;
    console.log(devolucao);
    var origem = document.getElementById("origemmovto").value;
    var tipomovto = document.getElementById("tipomovto").value;

   if(descricao == '' || origem == '#' || tipomovto == '#'){
       alert("Preencha todos os campos.");
   }
    else{
        var dados = {
            id: id,
            cod: cod,
            descricao: descricao,
            financeiro: financeiro,
            origem: origem,
            tipomovto: tipomovto,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario_criacao: usuario_criacao,
            usuario_atualizacao: usuario_atualizacao,
            inativo: inativo,
            devolucao: devolucao
        };
        console.log(dados);
        fetch("/owlsoftware/modulos/cadastro/tipo_venda/cadastro/controller/cadastrar.php", {
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
    document.getElementById("id").value ='';
    document.getElementById("codigo").value ='';
    document.getElementById("descricao").value = '';
    document.getElementById("origemmovto").value = '#';
    document.getElementById("tipomovto").value = '#';
    document.getElementById("financeiro").checked = false;
    document.getElementById("inativo").checked = false;

}
