var qnt_result_pg = 4; //quantidade de registro por página
var pagina = 1; //página inicial
var cod = document.getElementById("cod").value;
var descricao = document.getElementById("descricao").value;

var corpo = document.getElementById("conteudo");
corpo.addEventListener("load", pesquisarProd(pagina, 4, cod, descricao));
function pesquisarProd(pagina, qnt_result_pg, cod, descricao){
    if(cod == undefined){
        cod = document.getElementById("cod").value;
    }
    if(descricao == undefined){
        descricao = document.getElementById("descricao").value;
    }
    var dados = {
        pagina: pagina,
        qnt_result_pg: qnt_result_pg,
        cod: cod,
        descricao: descricao
    }
    console.log(dados);
    listar(dados)
}

listar(dados);
    function listar(dados){
        fetch('/owlsoftware/modulos/cadastro/produto/consulta/controllers/listar.php',{
            method: 'POST',
            body: JSON.stringify(dados),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            return response.text();
        }).then(function(text){
            document.getElementById('pesquisar').innerHTML = text;
        }).catch(function(error){
            console.log(error);
        })
    };

    function editar(id){
        window.location.href = "/owlsoftware/modulos/index.php?pag=produto&id="+id;
        
    } 