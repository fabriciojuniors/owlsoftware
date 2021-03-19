$(document).ready(function($){
    //$('.formatar').mask('000.000.000.000.000,00', {reverse: true});  
    url = window.location.href;
    params = new  URLSearchParams(url);
    nota = params.get("numero");
    aba = params.get("aba");
    if(nota != null){
        //console.log("oi");
        carregaNF(nota);
    }
    if(aba == "2"){
        setTimeout(() => {
            document.getElementById("itens-tab").click();    
        }, 100);
        
    }else if(aba == "3"){
        setTimeout(() => {
            document.getElementById("financeiro-tab").click();    
        }, 100);
        
    }
})
function limparNF(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido"
}
function pesquisarNF(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=consulta_nf_pedido"
}
function mascara(i){
    var v = i.value.replace(/\D/g,'');
    v = (v/100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    i.value = v;

}
function marcarTodos(checkdo){
    let tabela = document.getElementById("tbItens");
    let linhas = tabela.getElementsByTagName("tr");
    let qtd = linhas.length;
    checkdo = (checkdo) ? checkdo : false;
    for (let i = 0; i < qtd; i++) {
        let checkFaturar = "faturar"+i;
        document.getElementById(checkFaturar).checked = checkdo;
    }
}
function buscarClie(cod){
    var dados = {
        cod: cod
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteE.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        ////console.log(text);
        if(text == 'null'){
            alert("Não foi possível localizar cliente com o código informado.");
            document.getElementById("codCli").value = '';
            document.getElementById("nomeCli").value = '';
        }else{
            var cliente = JSON.parse(text);
            cliente.forEach(c => {
                document.getElementById("codCli").value = c.id;
                document.getElementById("nomeCli").value = c.nome;
            });
        }
    }).catch(function(error){
        //console.log(error);
    });

}
function pesquisarCli(){
    var CPF_CNPJ = document.getElementById("cpfcnpj").value;
    var nome = document.getElementById("nome").value;
    var dados = {
        cpfcnpj: CPF_CNPJ,
        nome: nome
    }
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteModal.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        
        var resultado = document.getElementById("divResultado")
        if(text == 'null'){
            resultado.innerHTML = "Não foi possível localizar clientes cadastrados.";
        }else{
            var clientes = JSON.parse(text);
            resultado.innerHTML = "<table id='tabelaResultado' class='table table-sm'><thead><th>Código</th><th>CPF/CNPJ</th><th>Nome</th><th>#</th></thead>";
            var tabela = document.getElementById("tabelaResultado");
            clientes.forEach(c => {
                var linha = tabela.insertRow(-1);
                var col1 = linha.insertCell(0);
                var col2 = linha.insertCell(1);
                var col3 = linha.insertCell(2);
                var col4 = linha.insertCell(3);
                col1.innerHTML = c.id;
                col2.innerHTML = c.CPF_CNPJ;
                col3.innerHTML = c.nome; 
                col4.innerHTML = "<a onclick='buscarClie("+c.id+")' data-toggle='modal' data-target='#modalCliente'><i class='fas fa-check'></i></a>"
            });
        }
    }).catch(function(error){
        //console.log(error);
    })
}