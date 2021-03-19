var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());
function carregaDados(){
    let url = new URL(location.href);
    let id = url.searchParams.get("id");
    
    if(id != ''){
        dados = {
            id: id
        };
        fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/carregaProd.php" , {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}}
        ).then(function(response){
            return response.text();
        }).then(function(text){
            setTimeout(() => {
                let produto = JSON.parse(text);
            
            produto.forEach(p => {
                document.getElementById("id").value = p.id;
                document.getElementById("cod").value = p.cod;
                document.getElementById("cod").disabled = true;
                document.getElementById("selecttprod").value = p.tprod;
                document.getElementById("descricao").value = p.descricao;
                document.getElementById("referencia").value = p.referencia;
                document.getElementById("selectgprod").value = p.gprod;
                document.getElementById("selectmarca").value = p.marca;
                document.getElementById("criacao").value = p.dt_criacao;
                document.getElementById("atualizacao").value = p.dt_alteracao;
                if(p.inativo == 1){
                    document.getElementById("inativo").checked = true;
                }else{
                    document.getElementById("inativo").checked = false;
                }
                document.getElementById("preco_maximo").value = p.preco_max;
                document.getElementById("preco_minimo").value = p.preco_min;
                document.getElementById("cor").value = p.cor;
                document.getElementById("tamanho").value = p.tamanho;
                
            });
                
            }, 100);
            
            
        })
        
    }
}
function pesquisar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=consulta_produto";
}
function limpar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=produto";
}
function confirmar(){
    let id = document.getElementById("id").value;
    let cod = document.getElementById("cod").value;
    let tprod = document.getElementById("selecttprod").value;
    let descricao = document.getElementById("descricao").value;
    let referencia = document.getElementById("referencia").value;
    let gprod = document.getElementById("selectgprod").value;
    let marca = document.getElementById("selectmarca").value;
    let criacao = document.getElementById("criacao").value;
    let atualizacao = document.getElementById("atualizacao").value;
    let inativo = document.getElementById("inativo").checked;
    inativo = (inativo == true) ? 1 : 0;
    let preco_maximo = document.getElementById("preco_maximo").value;
    preco_maximo = preco_maximo.split(".").join("");
    preco_maximo = preco_maximo.split(",").join(".");
    let preco_minimo = document.getElementById("preco_minimo").value;
    preco_minimo = preco_minimo.split(".").join("");
    preco_minimo = preco_minimo.split(",").join(".");
    let cor = document.getElementById("cor").value;
    
    let usuario = localStorage.getItem("usuario");

    if(tprod == '#' || descricao == '' || referencia == '' || gprod == '#' || marca == '#'){
        alert("Preencha todos os campos");
        if(tprod == '#'){
            document.getElementById("tprod").style.borderColor = "red";
        }
        if(descricao == ''){
            document.getElementById("descricao").style.borderColor = "red";
        }
        if(referencia == ''){
            document.getElementById("referencia").style.borderColor = "red";
        }
        if(gprod == '#'){
            document.getElementById("gprod").style.borderColor = "red";
        }
        if(marca == '#'){
            document.getElementById("marca").style.borderColor = "red";
        }
    }else{
        let dados = {
            id: id,
            cod: cod,
            tprod: tprod,
            descricao: descricao,
            referencia: referencia,
            gprod: gprod,
            marca: marca,
            criacao: criacao,
            atualizacao: atualizacao,
            inativo: inativo,
            preco_maximo: preco_maximo,
            preco_minimo: preco_minimo,
            cor: cor,
            usuario: usuario
        };
        console.log(dados);
        fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/cadastrar.php", {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}}
        ).then(function(response){
            return response.text();
        }).then(function(text){
            if(text == "Erro"){
                alert("Erro ao realizar cadastro do produto.");
            }else if(text == "Atualizou"){
                alert("Registro atualizado com sucesso.");
                attComentario(id);
            }
            else{
                
                 let resultado = JSON.parse(text);
                 alert("Produto cadastrado com sucesso.");
                 carregaId(resultado.id, resultado.cod);
            }
          
        })
    }
}
function carregaId(id, cod){
    document.getElementById("id").value = id;
    document.getElementById("cod").value = cod;
    document.getElementById("cod").disabled = true    ;
}