var corpo = document.getElementById("conteudo")
window.addEventListener("load", carregaDados());

function carregaDados(){
    carregaAjuste();
}

function editarAjuste(cod){
    window.location.href ="";
}
function carregaAjuste(cod, inicio, fim ){
    var dados = {
        cod: cod,
        inicio: inicio,
        fim: fim
    };
    fetch("/owlsoftware/modulos/estoque/ajuste/consulta/controller/carregaAjuste.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null' || text == ''){
            document.getElementById("div_resultado").innerHTML = "Nenhum ajuste cadastrado com os filtros informados.";
        }else{
            var ajustes = JSON.parse(text);
            document.getElementById("div_resultado").innerHTML = "<table class='table table-sm table-hover' id='resultado_ajuste'><thead><th>Código</th><th>Data</th><th>Observação</th><th>Editar</th></thead>"
            ajustes.forEach(ajuste => {
                var tabela = document.getElementById("resultado_ajuste");
                var linha = tabela.insertRow(1);
                var codigo = linha.insertCell(0);
                var data = linha.insertCell(1);
                var obs = linha.insertCell(2);
                var edit = linha.insertCell(3);
                codigo.innerHTML = ajuste[0];
                data.innerHTML = ajuste[1].split("-").reverse().join("/");
                obs.innerHTML = ajuste[2];
                edit.innerHTML = "<a href='/owlsoftware/modulos/index.php?pag=ajuste&codigo="+ajuste[0]+"'> <i class='fas fa-pen'></i></i> </a>"
            });

        }
    })

}