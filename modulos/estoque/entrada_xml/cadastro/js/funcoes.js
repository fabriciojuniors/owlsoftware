const carregarXML = () =>{
    document.querySelector("#enviaXML").submit();
}

function buscarProduto(cod, indice){
    var dados = {
        cod: cod,
        indice: indice
    };
    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/buscaProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        let j = indice-1;
        if(text == "Produto não localizado"){
            alert(text);
            console.log("descprod"+indice);
            document.getElementById("descprod"+((indice+1))).value ="";
            document.getElementById("codProd"+(indice+1)).value ="";
        }else{
            var prods = JSON.parse(text);
            prods.forEach(prod => {
                
                document.getElementById("descprod"+(indice+1)).value = prod.descricao;
                document.getElementById("codProd"+(indice+1)).value = prod.cod;
                
            });

        }
    });
    
}

function buscarProdutoM(cod, indice){
    var dados = {
        cod: cod,
        indice: indice
    };
    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/buscaProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        let j = indice-1;
        if(text == "Produto não localizado"){
            alert(text);
            console.log("descprod"+indice);
            document.getElementById("descprod"+((indice))).value ="";
            document.getElementById("codProd"+(indice)).value ="";
        }else{
            var prods = JSON.parse(text);
            prods.forEach(prod => {
                
                document.getElementById("descprod"+(indice)).value = prod.descricao;
                document.getElementById("codProd"+(indice)).value = prod.cod;
                
            });

        }
    });
    
}

function selecaoProd(indice){
    var dados = {
        descricao: document.getElementById("s_descricao").value,
        grupo: document.getElementById("g_prod").value,
        tipo: document.getElementById("t_prod").value,
        indice: indice
    };

    fetch("/owlsoftware/modulos/estoque/entrada_xml/cadastro/controller/selecaoProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Nenhum produto localizado."){
            alert(text);
            document.getElementById("descprod"+(indice-1)).value ="";
            document.getElementById("codprod"+(indice-1)).value ="";
        }else{
            document.getElementById("resultado_produtos").innerHTML = text;
        }
    });
    
}