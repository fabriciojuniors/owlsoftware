var corpo = document.getElementById("conteudo")
window.addEventListener("load", carregaDados());

function carregaDados(){
    carregaTpMovto();
    carregaTamanho();
    
}
function carregaTpMovto(){
    fetch("/owlsoftware/modulos/estoque/kardex/controller/carregaTpMovto.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tpmovtos = JSON.parse(text);
        tpmovtos.forEach(tpmovto => {
            var select = document.getElementById("selecttpmovto");
            var opt = document.createElement("option");
            opt.value = tpmovto.id;
            opt.text = tpmovto.descricao;
            select.add(opt);
        });
    })
}
function carregaTamanho(){
    fetch("/owlsoftware/modulos/estoque/kardex/controller/carregaTamanho.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tamanhos = JSON.parse(text);
        tamanhos.forEach(tamanho => {
            var select = document.getElementById("selecttamanho");
            var opt = document.createElement("option");
            opt.value = tamanho.id;
            opt.text = tamanho.descricao;
            select.add(opt);
        });
    })
}

function buscaProd(cod){
    var dados = {
        cod: cod
    };
    fetch("/owlsoftware/modulos/estoque/kardex/controller/buscaProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Produto não localizado"){
            alert(text);
            document.getElementById("descprod").value ='';
            document.getElementById("codprod").value ='';

        }else{
            var prods = JSON.parse(text);
            prods.forEach(prod => {
                var campo = document.getElementById("descprod");
                campo.value = prod.descricao;
            });

        }
    });
    
}

function pesquisar(){
    var dtinicial = document.getElementById("dtinicial").value;
    var dtfinal = document.getElementById("dtfinal").value;
    var produto  = document.getElementById("codprod").value;
    var tamanho = document.getElementById("selecttamanho").value;
    var tpmovto = document.getElementById("selecttpmovto").value;
    var dados = {
        dtinicial: dtinicial,
        dtfinal: dtfinal,
        produto: produto,
        tamanho: tamanho,
        tpmovto: tpmovto
    };
    fetch("/owlsoftware/modulos/estoque/kardex/controller/kardex.php", {
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'} 
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
        var resultado_kardex = document.getElementById("resultado_kardex");
        if(text === 'null' ){
            resultado_kardex.innerHTML = '';
            alert("Não foi possível localizar movimentação com os filtros informados.");
        }else{
           var movimentacoes = JSON.parse(text);
           resultado_kardex.innerHTML = "<table id='tabela_resultado' class='table table-sm'> <thead> <th>Data</th><th>Tipo movto.</th><th>Origem Movto.</th><th>N° Doc</th><th>Quantidade</th><th>Custo</th>"
           var tabela = document.getElementById("tabela_resultado");

           movimentacoes.forEach(m => {
            var linha = tabela.insertRow(1);
            var col0 = linha.insertCell(0);
            var col = linha.insertCell(1);
            var col1 = linha.insertCell(2);
            var col2 = linha.insertCell(3);
            var col4 = linha.insertCell(4);
            var col5 = linha.insertCell(5);
               col0.innerHTML = m.data.split("-").reverse().join("/");
               col1.innerHTML = m.origem;
               col2.innerHTML = m.num_doc;
               col4.innerHTML = m.quantidade;
               col5.innerHTML = m.valor;
               col.innerHTML = m.tp_movto;
           });
                    // setTimeout(() => {
                    //     qtdEntrada(dtinicial, dtfinal, produto, tamanho, tpmovto);     
                    // }, 100);
                    // setTimeout(() => {
                    //     qtdSaida(dtinicial, dtfinal, produto, tamanho, tpmovto);
                    // }, 100);
                    // saldo();
                    carregaSaldo();
                    
        }
    })
}
function carregaSaldo(){
    var dados = {produto : document.getElementById("codprod").value};
    fetch("/owlsoftware/modulos/estoque/kardex/controller/carregaSaldo.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var resultado = JSON.parse(text);
        var r = document.getElementById("qtdEntrada");
        r.innerHTML = "Entrada: " + resultado[0] + "<br> Saída: " + resultado[1] + "<br> Saldo: " + resultado[2];
    });

};