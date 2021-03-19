var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());

function carregaDados(){
    fetch("/owlsoftware/modulos/cadastro/tipo_movto_financeiro/controller/Ctp_movto_financeiro.php",{
        headers: {'Content-type': 'Application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var resultado = document.getElementById("resultado");
        var table = resultado.innerHTML = "<table class='table table-sm' id='tabelaResultado'><thead><th>Código</th><th>Descrição</th><th>#</th></thead></table>"
        var tabelaResultado = document.getElementById("tabelaResultado");
        tipos = JSON.parse(text);
        tipos.forEach(t => {
            if(t[4] == 1){
                var linha = tabelaResultado.insertRow(1);
                linha.style.color = 'red';
            }else{
                var linha = tabelaResultado.insertRow(1);
            }
            
            var col1 = linha.insertCell(0);
            var col2 = linha.insertCell(1);
            var col3 = linha.insertCell(2);
            col1.innerHTML = t[0];
            col2.innerHTML = t[1];
            col3.innerHTML = "<a onclick='editar("+t[0]+")'><i class='fas fa-pen'></i></a>";
        });
    }).catch(function(error){
        alert(error);
    })
}
function editar(cod){
    var dados = {
        cod: cod
    }
    fetch("/owlsoftware/modulos/cadastro/tipo_movto_financeiro/controller/Btp_movto_financeiro.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-type': 'Application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var t = JSON.parse(text);
        t.forEach(ts => {
            document.getElementById("cod").value = ts.id;
            document.getElementById("descricao").value = ts.descricao;    
            (ts.liquidacao ==1 )?document.getElementById("liquidacao").checked =true: document.getElementById("liquidacao").checked = false; 
            (ts.desconto ==1 )?document.getElementById("desconto").checked =true: document.getElementById("desconto").checked = false; 
            (ts.inativo ==1 )?document.getElementById("inativo").checked =true: document.getElementById("inativo").checked = false; 
        });
        
    }).catch(function(error){
        alert(error);
    })
}
function confirmar(){
    var cod = document.getElementById("cod").value;
    var descricao = document.getElementById("descricao").value;
    var desconto = document.getElementById("desconto").checked;
    var liquidacao = document.getElementById("liquidacao").checked;
    var inativo = document.getElementById("inativo").checked;
    inativo = (inativo)? 1 : 0;
    desconto = (desconto) ? 1 : 0;
    liquidacao = (liquidacao) ? 1 : 0;

    var dados = {
        cod: cod,
        descricao: descricao,
        desconto: desconto,
        liquidacao: liquidacao,
        inativo: inativo
    }

    fetch("/owlsoftware/modulos/cadastro/tipo_movto_financeiro/controller/tp_movto_financeiro.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-type': 'Application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        alert(text);
        limpar();
    }).catch(function(error){
        alert(error);
    })
}
function limpar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=movto_financeiro";
}