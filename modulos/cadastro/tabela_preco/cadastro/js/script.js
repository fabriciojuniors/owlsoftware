$(document).ready(function($){
    $('#max_desconto').mask('000.000.000.000.000,00', {reverse: true});
    
    if(!document.querySelector("#codigo").value){
        document.querySelector("#nav-produto-tab").classList.add("disabled");
    }
});

const confirmar = () =>{
    let codigo = document.querySelector("#codigo").value;
    let descricao = document.querySelector("#descricao").value;
    let max_desconto = document.querySelector("#max_desconto").value;
    let criacao = document.querySelector("#criacao").value;

    if(!descricao || !max_desconto){
        alert("Preencha todos os campos.");
        return;
    }

    max_desconto = max_desconto.split(",").join(".");
    let dados = {
        codigo: codigo,
        descricao: descricao,
        max_desconto: max_desconto,
        criacao: criacao
    }

    fetch("/owlsoftware/modulos/cadastro/tabela_preco/cadastro/controller/cadastro.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-type' : 'Application/JSON'}
    }).then((response) =>{
        return response.text();
    }).then((text) =>{
        try {
            let id = parseInt(text);
            window.location.href = "/owlsoftware/modulos/index.php?pag=tabela_preco&id="+id;
        } catch (error) {
            alert(text)
        }
    }).catch((e)=>{
        alert("Erro ao conectar com servidor. \n" + e)
    })
}

