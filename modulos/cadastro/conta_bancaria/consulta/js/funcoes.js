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

        fetch('/owlsoftware/modulos/cadastro/conta_bancaria/consulta/controllers/listar.php',{
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

    function editar(id, cod, banco, agencia, dvagencia, conta, dvconta, inativo,criacao, usuario, titular){
        document.getElementById("id").value = id;
        document.getElementById("codigo").value = cod;
        document.getElementById("dt_criacao").value = criacao;
        document.getElementById("portador").value = banco;
        document.getElementById("agencia").value = agencia;
        document.getElementById("dvagencia").value = dvagencia;
        document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: "+ usuario;
        document.getElementById("conta").value = conta;
        document.getElementById("dvconta").value = dvconta;
        document.getElementById("titular").value = titular;
        if(inativo == 1){
            document.getElementById("inativo").checked = true;
        } else{
            document.getElementById("inativo").checked = false;
        };
        
    } 