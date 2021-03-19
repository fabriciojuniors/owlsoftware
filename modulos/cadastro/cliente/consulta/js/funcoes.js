$(document).ready(function($){
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
    
    
});
var qnt_result_pg = 4; //quantidade de registro por página
var pagina = 1; //página inicial
var cod = document.getElementById("cpfcnpj").value;
var descricao = document.getElementById("nome").value;

var corpo = document.getElementById("conteudo");
window.addEventListener("load", pesquisarProd(pagina, 4, cod, descricao));
function pesquisarProd(pagina, qnt_result_pg, cod, descricao){
    if(cod == undefined){
        cod = document.getElementById("cpfcnpj").value;
    }
    if(descricao == undefined){
        descricao = document.getElementById("nome").value;
    }
    var dados = {
        pagina: pagina,
        qnt_result_pg: qnt_result_pg,
        cod: cod,
        descricao: descricao
    };
    console.log(dados);
    listar(dados);
}

    function listar(dados){
        fetch('/owlsoftware/modulos/cadastro/cliente/consulta/controllers/listar.php',{
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
        window.location.href = "/owlsoftware/modulos/index.php?pag=cliente&id="+id;
        
    };
    function limpar(){
        window.location.href = "/owlsoftware/modulos/index.php?pag=cliente";
    }