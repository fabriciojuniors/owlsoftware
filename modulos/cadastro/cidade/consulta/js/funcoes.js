var qnt_result_pg = 5; //quantidade de registro por página
var pagina = 1; //página inicial
listar(pagina, qnt_result_pg);
    window.addEventListener("load",function(e){  
        e.preventDefault();
        listar(pagina, qnt_result_pg); //Chamar a função para listar os registros
    });
    function listar(pagina, qnt_result_pg){
        
        var dados = {
            pagina: pagina,
            qnt_result_pg: qnt_result_pg
        }

        fetch('/owlsoftware/modulos/cadastro/cidade/consulta/controllers/listar.php',{
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

    function editar(id, cod, descricao, uf, pais, ufNome){
        carregaUF(pais, uf);
        console.log(pais);
        document.getElementById("codigo").value = cod;
        document.getElementById("codigo").setAttribute('disabled', 'disabled');
        document.getElementById("nome").value = descricao;
        document.getElementById("id").value = id;
        document.getElementById("Selectpais").value = pais;
        
    } 