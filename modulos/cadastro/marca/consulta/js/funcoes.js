var qnt_result_pg = 4; //quantidade de registro por página
var pagina = 1; //página inicial
listar(pagina, qnt_result_pg);
    window.onload = function(e){
        e.preventDefault();
        listar(pagina, qnt_result_pg); //Chamar a função para listar os registros
    };
    function listar(pagina, qnt_result_pg){
        
        var dados = {
            pagina: pagina,
            qnt_result_pg: qnt_result_pg
        }

        fetch('/owlsoftware/modulos/cadastro/marca/consulta/controllers/listar.php',{
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

    function editar(id, cod, descricao, inativo, usuario, data){
        document.getElementById("codigo").value = cod;
        document.getElementById("descricao").value = descricao;
        document.getElementById("id").value = id;
        document.getElementById("criacao").value = data
        document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: "+ usuario;
        if(inativo == 1){
            document.getElementById("inativo").checked = true;
        } else{
            document.getElementById("inativo").checked = false;
        }
        if(avista == 1){
            document.getElementById("venda").checked = true;
        } else{
            document.getElementById("venda").checked = false;
        }
    } 