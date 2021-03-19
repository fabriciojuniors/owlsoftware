$(document).ready(function($){
    $("#quantidade").mask('000.000.000.000.000,00', {reverse: true});
    $("#custo").mask('000.000.000.000.000,00', {reverse: true});
    var url_string = window.location.href; //window.location.href
    var url = new URL(url_string);
    var param = url.searchParams.get("codigo");
    ////console.log(param)
    if(param == null){
        //console.log("nulo");
    }else{
       document.getElementById("codigo").value = param;
       carregaItemAjuste();
       document.getElementById("tpmovto").disabled = false;
       document.getElementById("codprod").disabled = false;
       document.getElementById("lupaProd").style.pointerEvents = "all";
       document.getElementById("selecttamanho").disabled = false;
       document.getElementById("custo").disabled = false;
       document.getElementById("adicionar").disabled = false;
       document.getElementById("quantidade").disabled = false;
    }
})

var corpo = document.getElementById("conteudo")
window.addEventListener("load", carregaDados());

function carregaDados(){
    carregaTpMovto();
    carregaTamanho();
    //carregaConsulta();
   
}
function carregaConsulta(){
    
};
function carregaItemAjuste(){
    var dados = {
        ajuste: document.getElementById("codigo").value
    }
    //console.log(dados);
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/carregaItemAjuste.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tabela = document.getElementById("tabela_ajuste");
        while(tabela.rows.length != 1){
            tabela.deleteRow(1);
        }
        //console.log(text);
        var itens = JSON.parse(text);
        itens.forEach(item => {

            var linha = tabela.insertRow(-1);
            var codigo = linha.insertCell(0);
            var descricao = linha.insertCell(1);
            var quantidade = linha.insertCell(2);
            var custo = linha.insertCell(3);
            var tamanho = linha.insertCell(4);
            var excluir = linha.insertCell(5);
            codigo.innerHTML = item.cod;
            descricao.innerHTML = item[2];
            quantidade.innerHTML = item.quantidade;
            custo.innerHTML = item.custo;
            tamanho.innerHTML = item[4];
            excluir.innerHTML = "<a href='' onclick=excluirMovto("+item[0]+")><i class='fas fa-trash-alt'></i></a>";
        });


    })

}

function carregaTpMovto(){
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/carregaTpMovto.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tpmovtos = JSON.parse(text);
        tpmovtos.forEach(tpmovto => {
            var select = document.getElementById("tpmovto");
            var opt = document.createElement("option");
            opt.value = tpmovto.id;
            opt.text = tpmovto.descricao;
            select.add(opt);
        });
    })
}
function carregaTamanho(){
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/carregaTamanho.php",{
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
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/buscaProd.php",{
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

function carregaInfo(){
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/carregaGrupo.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tamanhos = JSON.parse(text);
        tamanhos.forEach(tamanho => {
            var select = document.getElementById("g_prod");
            var opt = document.createElement("option");
            opt.value = tamanho.id;
            opt.text = tamanho.descricao;
            select.add(opt);
        });
    });
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/carregaTipo.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var tamanhos = JSON.parse(text);
        tamanhos.forEach(tamanho => {
            var select = document.getElementById("t_prod");
            var opt = document.createElement("option");
            opt.value = tamanho.id;
            opt.text = tamanho.descricao;
            select.add(opt);
        });
    })
}

function selecaoProd(){
    var dados = {
        descricao: document.getElementById("s_descricao").value,
        grupo: document.getElementById("g_prod").value,
        tipo: document.getElementById("t_prod").value
    };

    fetch("/owlsoftware/modulos/estoque/ajuste/controller/selecaoProd.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Nenhum produto localizado."){
            alert(text);

        }else{
            document.getElementById("resultado_produtos").innerHTML = text;
        }
    });
    
}
function salvarAjuste(){
    var data = document.getElementById("datamovto").value;
    var obs = document.getElementById("observacao").value;
    var codigo = document.getElementById("codigo").value
    if(data == ''){
        alert("Preencha todos os campos");
    }else if(codigo != ""){
        alert("Não é possível gerar um novo ajuste, código já gerado.");
    }else{
        var dados = {
            data: data,
            obs: obs
        }
        fetch("/owlsoftware/modulos/estoque/ajuste/controller/savarAjuste.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            var resposta  = parseInt(text);
            if(typeof resposta === 'number' ){
                document.getElementById("codigo").value = resposta;
                document.getElementById("tpmovto").disabled = false;
                document.getElementById("codprod").disabled = false;
                document.getElementById("lupaProd").style.pointerEvents = "all";
                document.getElementById("selecttamanho").disabled = false;
                document.getElementById("custo").disabled = false;
                document.getElementById("adicionar").disabled = false;
                document.getElementById("quantidade").disabled = false;
            }else{
                alert(text);
            }
        });

    }
}
function movimentarEstoque(produto, quantidade, custo, tamanho, movimento, ajuste){
    custo= custo.split('.').join("");
    custo = custo.replace(',','.');
    quantidade= quantidade.split('.').join("");
    quantidade= quantidade.replace(',','.');
    var dados = {
        ajuste: ajuste,
        tpmovto: movimento,
        produto: produto,
        tamanho: tamanho,
        quantidade: quantidade,
        custo: custo        
    };
    //console.log(tamanho);
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/itemAjuste.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'Salvo'){
            id = 'movimentar'+produto;
            document.getElementById(id).disabled = true;
            document.getElementById('excluir'+produto).style.pointerEvents = "all";
            document.getElementById('excluir'+produto).title = '';
            carregaItemAjuste();
        }else{
            alert(text);
            id = 'movimentar'+produto;
            document.getElementById(id).checked = false;
        }
    });
    
}
function adicionar(){
    var tpmovto = document.getElementById("tpmovto").value;
    var produto = document.getElementById("codprod").value;
    var tamanho = document.getElementById("selecttamanho").value;
    var quantidade = document.getElementById("quantidade").value;
    var custo = document.getElementById("custo").value;
    var ajuste = document.getElementById("codigo").value;

    if(tpmovto == '#' || produto == '' || tamanho == '#' || quantidade == '' || custo == ''){
        alert("Preencha todos os campos");
        if(tpmovto == '#'){
            document.getElementById("tpmovto").style.borderColor = "red";
        }
        if(produto == ''){
            document.getElementById("codprod").style.borderColor = "red";
        }
        if(tamanho == '#'){
            document.getElementById("tamanho").style.borderColor = "red";
        }
        if(quantidade == ''){
            document.getElementById("quantidade").style.borderColor = "red";
        }
        if(custo == ''){
            document.getElementById("custo").style.borderColor = "red";
        }
    }else{
        custo= custo.split('.').join("");
        custo = custo.replace(',','.');
        quantidade= quantidade.split('.').join("");
        quantidade= quantidade.replace(',','.');
        var dados = {
            ajuste: ajuste,
            tpmovto: tpmovto,
            produto: produto,
            tamanho: tamanho,
            quantidade: quantidade,
            custo: custo
        };

        fetch("/owlsoftware/modulos/estoque/ajuste/controller/itemAjuste.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            if(text == 'Salvo'){
                document.getElementById("tpmovto").value = '#';
                document.getElementById("codprod").value = '';
                document.getElementById("selecttamanho").value  ='#';
                document.getElementById("quantidade").value ='';
                document.getElementById("custo").value ='';
                document.getElementById("descprod").value = '';
                carregaItemAjuste();
            }else{
                alert(text);

            }
        });
    }
}
function limpar(){
    window.location.href ="/owlsoftware/modulos/index.php?pag=ajuste"; 
}
function pesquisar(){
    window.location.href ="/owlsoftware/modulos/index.php?pag=consulta_ajuste"; 
}

function excluirMovto(produto){
    event.preventDefault()
    var dados = {
        produto: produto
    }
    fetch("/owlsoftware/modulos/estoque/ajuste/controller/removeItem.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        //console.log(text);
        //if(text == 'Excluido'){
            carregaItemAjuste();
            id = 'movimentar'+produto;
            document.getElementById(id).checked = false;
            document.getElementById(id).disabled = false;
            document.getElementById('excluir'+produto).style.pointerEvents = "none";
            
        //}else{  
          //  alert(text);
        //}
    });
}