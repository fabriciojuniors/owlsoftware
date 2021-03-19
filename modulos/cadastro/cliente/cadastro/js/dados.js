$(window).ready(function($){
    $('.phone_with_ddd').mask('(00) 9 0000-0000');
    $("#cpfcnpj").keydown(function(){
        try {
            $("#cpfcnpj").unmask();
        } catch (e) {}

        var tamanho = $("#cpfcnpj").val().length;
        if(tamanho < 11){
            $("#cpfcnpj").mask("999.999.999-99");
        } else if(tamanho >= 11){
            $("#cpfcnpj").mask("99.999.999/9999-99");
        }
        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    })
 
})

var corpo = document.getElementById("conteudo");
window.addEventListener("load", Dados());

function Dados(){
    carregaPais();    
} 
function carregaPais(){
    fetch("/owlsoftware/modulos/cadastro/cliente/cadastro/controller/carregaPais.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        let tps = JSON.parse(text);
        tps.forEach(tp => {
            if(tp.inativo != 1){
                let x = document.getElementById("selectpais");
                let option = document.createElement("option");
                if(tp.descricao == "BRASIL"){
                    option.selected = true;
                    carregaUF(tp.id);
                }
                option.value = tp.id;
                option.text = tp.descricao;
                x.add(option);
            }
        });
    })
}
function carregaUF(pais, uf, cidade){
    var pais = {
        pais: pais
    };
    fetch("/owlsoftware/modulos/cadastro/cliente/cadastro/controller/carregaUF.php", {
        method: "POST",
        body: JSON.stringify(pais),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        //console.log(text);
        var x = document.getElementById("selectuf");
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
            if(uf === undefined){
                if(ufs.id == uf){
                    var option = document.createElement("option");
                    option.value = ufs.id;
                    option.text = ufs.descricao;
                    option.selected = true;
                    x.add(option);   
                }
                else{
                var option = document.createElement("option");
                option.value = ufs.id;
                option.text = ufs.descricao;
                x.add(option);}
                }
            else{
                
                if(ufs.id == uf || ufs.sigla == uf.toUpperCase()){
                    var option = document.createElement("option");
                    option.value = ufs.id;
                    option.text = ufs.descricao;
                    option.selected = true;
                    x.add(option);  
                    carregacidade(ufs.id, cidade);
                }
                else{
                var option = document.createElement("option");
                option.value = ufs.id;
                option.text = ufs.descricao;
                x.add(option);}
                }  
            }
            );
        
    }).catch(function(erro){
        alert("Nenhuma UF cadastrada para o país selecionado. \n" + erro);
    })
}

function carregacidade(uf, cidade){
    var uf = {
        uf: uf
    };
    fetch("/owlsoftware/modulos/cadastro/cliente/cadastro/controller/carregaCidade.php", {
        method: "POST",
        body: JSON.stringify(uf),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        //console.log(text);
        var x = document.getElementById("selectcidade");
        var y = x.getElementsByTagName("OPTION");
        for(var i = 1; y.length; i++){
            x.remove(y[i]);
        }        
        var padrao = document.createElement("option");
        padrao.value = "#";
        padrao.text = "Selecione";
        x.add(padrao);
        result = JSON.parse(text);
        result.forEach(cidades => {
        if(cidades.id == cidade || cidades.descricao == cidade){
            var option = document.createElement("option");
            option.value = cidades.id;
            option.text = cidades.descricao;
            option.selected = true;
            x.add(option);   
        }
        else{
        var option = document.createElement("option");
        option.value = cidades.id;
        option.text = cidades.descricao;
        x.add(option);}
        });
        
    }).catch(function(erro){
        alert("Nenhuma cidade cadastrada para o estado selecionado. \n" + erro);
    })
}
function selecaoCidade(cidade){
    $("#selectcidade option").filter(function() {
        return $(this).text() ==cidade;
    }).prop("selected", true);
}



