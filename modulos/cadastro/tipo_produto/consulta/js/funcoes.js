var qnt_result_pg = 4; //quantidade de registro por página
var pagina = 1; //página inicial
listar_usuario(pagina, qnt_result_pg);
    window.onload = function(e){
        e.preventDefault();
        listar_usuario(pagina, qnt_result_pg); //Chamar a função para listar os registros
    };
    function listar_usuario(pagina, qnt_result_pg){
        
        var dados = {
            pagina: pagina,
            qnt_result_pg: qnt_result_pg
        }

        fetch('/owlsoftware/modulos/cadastro/tipo_produto/consulta/controllers/listar_tipo_produto.php',{
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

function editar(id, cod, descricao, inativo, usuario){
    document.getElementById("codigo").value = cod;
    document.getElementById("codigo").setAttribute('disabled', 'disabled');
    document.getElementById("descricao").value = descricao;
    document.getElementById("id").value = id;
    document.getElementById("nomeusuario").innerHTML = "Usuario cadastro: "+ usuario;
    if(inativo == 1){
        document.getElementById("inativo").checked = true;
    } else{
        document.getElementById("inativo").checked = false;
    }
}