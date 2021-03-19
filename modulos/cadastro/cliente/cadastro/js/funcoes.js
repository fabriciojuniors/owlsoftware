var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());
function carregaDados(){
    let url = new URL(location.href);
    let id = url.searchParams.get("id");
   
    if(id != ''){
        dados = {
            id: id
        };
            fetch("/owlsoftware/modulos/cadastro/cliente/cadastro/controller/carregaCliente.php" , {
                method: "POST",
                body: JSON.stringify(dados),
                headers: {'Content-Type': 'application/json'}}
            ).then(function(response){
                return response.text();
            }).then(function(text){
                setTimeout(() => {
                    try {
                        clientes = JSON.parse(text);
                    clientes.forEach(c => {
                        let id = document.getElementById("id").value = c.id;
                        let cod_webmais = document.getElementById("cod_webmais").value = c.cod_webmais;
                        let cpfcnpj = document.getElementById("cpfcnpj").value = c.CPF_CNPJ;
                        document.getElementById("cpfcnpj").disabled = "disabled";
                        let nome = document.getElementById("nome").value = c.nome;
                        let razao = document.getElementById("razaosocial").value = c.razao_social;
                        let telefone = document.getElementById("telefone").value = c.telefone;
                        let email = document.getElementById("email").value = c.email;
                        let datanascimento = document.getElementById("datanascimento").value = c.data_nascimento;
                        let sexo = document.getElementById("sexo").value = c.sexo;
                        let criacao = document.getElementById("data_criacao").value = c.dt_criacao;
                        let cep  = document.getElementById("cep").value = c.CEP;
                        let pais = document.getElementById("selectpais").value = c.pais;
                        carregaUF(c.pais, c.uf, c.cidade);
                        let uf = document.getElementById("selectuf").value = c.uf;
                        // carregacidade(c.uf, c.cidade);
                        //document.getElementById("selectcidade").value = c.cidade;
                        //selecaoCidade(c.cidade);
                        let cidade = document.getElementById("selectcidade").value = c.cidade;
                        let bairro = document.getElementById("bairro").value = c.bairro;
                        let rua = document.getElementById("rua").value = c.rua;
                        let complemento = document.getElementById("complemento").value = c.complemento;
                        if(c.inativo == 1){
                            document.getElementById("inativo").checked = true;
                        }
                        if(c.cliente == 1){
                            document.getElementById("scliente").checked = true;
                        }
                        if(c.fornecedor == 1){
                            document.getElementById("fornecedor").checked = true;
                        }
                        
                    });
                    } catch (error) {
                    }
                    
                   
                }, 100);
               
               
            })
       
    }
}
function pesquisar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=consulta_cliente";
}
function limpar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=cliente";
}

function confirmar(){
    let id = document.getElementById("id").value;
    let cpfcnpj = document.getElementById("cpfcnpj").value;
    let nome = document.getElementById("nome").value;
    let razao = document.getElementById("razaosocial").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;
    let datanascimento = document.getElementById("datanascimento").value;
    let sexo = document.getElementById("sexo").value;
    let criacao = document.getElementById("data_criacao").value;
    let atualizacao = document.getElementById("data_atualizacao").value;
    let usuario = localStorage.getItem("usuario");
    let cep  = document.getElementById("cep").value;
    let pais = document.getElementById("selectpais").value;
    let uf = document.getElementById("selectuf").value;
    let cidade = document.getElementById("selectcidade").value;
    let bairro = document.getElementById("bairro").value;
    let rua = document.getElementById("rua").value;
    let complemento = document.getElementById("complemento").value;
    var cliente = document.getElementById("scliente").checked;
    cliente = (cliente) ? 1 : 0;
    var fornecedor = document.getElementById("fornecedor").checked;
    fornecedor = (fornecedor) ? 1 : 0;
    let inativo = document.getElementById("inativo").checked;
    inativo = (inativo) ? 1 : 0;
    let cod_webmais = document.getElementById("cod_webmais").value;

    if(cpfcnpj == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("cpfcnpj").style.borderColor = "red";
    } else if(nome == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("nome").style.borderColor = "red";
    } else if(telefone == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("telefone").style.borderColor = "red";
    } else if(email == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("email").style.borderColor = "red";
    } else if(datanascimento == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("datanascimento").style.borderColor = "red";
    } else if(sexo == '#'){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("sexo").style.borderColor = "red";
    } else if(cep == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("cep").style.borderColor = "red";
    } else if(pais == '#'){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("pais").style.borderColor = "red";
    } else if(uf == '#'){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("uf").style.borderColor = "red";
    } else if(cidade == '#'){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("cidade").style.borderColor = "red";
    } else if(bairro == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("bairro").style.borderColor = "red";
    } else if(rua == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("rua").style.borderColor = "red";
    }else if(cod_webmais == ''){
        alert("Preencha todos os campos requiridos.")
        document.getElementById("cod_webmais").style.borderColor = "red";
    }
    else{
        let dados = {
            id: id,
            cpfcnpj: cpfcnpj,
            nome: nome,
            razao: razao,
            telefone: telefone,
            email: email,
            datanascimento: datanascimento,
            sexo: sexo,
            criacao: criacao,
            atualizacao: atualizacao,
            usuario: usuario,
            cep: cep,
            pais: pais,
            uf: uf,
            cidade: cidade,
            bairro: bairro,
            rua: rua,
            complemento: complemento,
            inativo: inativo,
            cliente: cliente,
            fornecedor: fornecedor,
            cod_webmais: cod_webmais
        };
        fetch("/owlsoftware/modulos/cadastro/cliente/cadastro/controller/cadastrar.php", {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            alert(text);
        })
    }
}