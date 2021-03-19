var corpo = document.getElementById("conteudo2");
window.addEventListener("load", infos());
function infos(){
    fetch("/owlsoftware/modulos/cadastro/cidade/cadastro/controller/info.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        result = JSON.parse(text);
        var x = document.getElementById("Selectpais");
        result.forEach(uf => {
            var option = document.createElement("option");
            option.value = uf.id;
            option.text = uf.nome;
            x.add(option);
        });
    }).catch(function(error){
        console.log(error);
    })
}
function carregaUF(pais, uf){
    var pais = {
        pais: pais
    };
    fetch("/owlsoftware/modulos/cadastro/cidade/cadastro/controller/consultaUF.php", {
        method: "POST",
        body: JSON.stringify(pais),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var x = document.getElementById("uf");
        var y = x.getElementsByTagName("OPTION");
        for(var i = 1; y.length; i++){
            x.remove(y[i]);
        }        
        var padrao = document.createElement("option");
        padrao.value = "#";
        padrao.text = "Selecione";
        x.add(padrao);
        result = JSON.parse(text);
        result.forEach(ufs => {
        if(ufs.id == uf){
            var option = document.createElement("option");
            option.value = ufs.id;
            option.text = ufs.uf;
            option.selected = true;
            x.add(option);   
        }
        else{
        var option = document.createElement("option");
        option.value = ufs.id;
        option.text = ufs.uf;
        x.add(option);}
        });
        
    }).catch(function(erro){
        alert("Nenhuma UF cadastrada para o país selecionado. \n" + erro);
    })
}

function confirmar(){
    var id = document.getElementById("id").value;
    var cod = document.getElementById("codigo").value;
    var descricao = document.getElementById("nome").value;
    var pais = document.getElementById("pais").value;
    var uf = document.getElementById("uf").value;
    

    if(descricao == ''){
        alert("Preencha todos os campos.");
        document.getElementById("descricao").style.borderColor = "red";
    } else if(pais == "#"){
        alert("Preencha todos os campos.");
        document.getElementById("pais").style.borderColor = "red";
    }else if(uf == "#"){
        alert("Preencha todos os campos.");
        document.getElementById("uf").style.borderColor = "red";
    } else{
        var dados = {
            id: id,
            cod: cod,
            descricao: descricao,
            pais: pais,
            uf: uf,
        };
        console.log(dados);
        fetch("/owlsoftware/modulos/cadastro/cidade/cadastro/controller/cadastrar.php", {
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
    var pais = document.getElementById("pais").value = '';
}
