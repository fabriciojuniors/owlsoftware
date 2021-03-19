var corpo = document.getElementById("conteudo");
window.addEventListener("load", infos());

function infos(){
    fetch("/owlsoftware/modulos/cadastro/conta_bancaria/cadastro/controller/carregaPortador.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        if(text == "Erro"){
            alert("Erro ao obter lista de portadores.")
        }else{
            var bancos = JSON.parse(text);
            bancos.forEach(banco => {
                var x = document.getElementById("portador");
                var option = document.createElement("option");
                option.value = banco.id;
                option.text = banco.nome;
                x.add(option);
            });

        }
        
    })

    
};

function confirmar(){
    var id = document.getElementById("id").value;
    var codigo = document.getElementById("codigo").value;
    var criacao = document.getElementById("dt_criacao").value;
    var portador = document.getElementById("portador").value;
    var atualizacao = document.getElementById("dt_atualizacao").value;
    var agencia = document.getElementById("agencia").value;
    var dvagencia = document.getElementById("dvagencia").value;
    var usuario = localStorage.getItem("usuario");
    var inativo = document.getElementById("inativo").checked;
    inativo = (inativo) ? 1 : 0;
    var conta = document.getElementById("conta").value;
    var dvconta = document.getElementById("dvconta").value;
    var titular = document.getElementById("titular").value;

    if(portador == '#' || agencia == '' || conta == '' || titular == ''){
        alert("Preencha todos os campos.");
        if(portador == '#'){
            document.getElementById("portador").style.borderColor = "red";
        }
        if(agencia == ''){
            document.getElementById("agencia").style.borderColor = "red";
        }
        if(conta == ''){
            document.getElementById("conta").style.borderColor = "red";
        }
        if(titular == ''){
            document.getElementById("titular").style.borderColor = "red";
        }
    } else{
        var dados = {
            id: id,
            codigo: codigo,
            criacao: criacao,
            portador: portador,
            atualizacao: atualizacao,
            agencia: agencia,
            dvagencia: dvagencia,
            usuario: usuario,
            inativo: inativo,
            conta: conta,
            dvconta: dvconta,
            titular: titular
        };
        fetch("/owlsoftware/modulos/cadastro/conta_bancaria/cadastro/controller/cadastrar.php", {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            alert(text);
            limpar();
            location.reload();
        }).catch(function(error){
            alert(error);
        })    

    }
    
}
function limpar(){
    document.getElementById("id").value ='';
    document.getElementById("codigo").value ='';
    document.getElementById("portador").value ='#';
    document.getElementById("agencia").value ='';
    document.getElementById("dvagencia").value ='';
    document.getElementById("inativo").checked = false;
    document.getElementById("conta").value ='';
    document.getElementById("dvconta").value ='';
    document.getElementById("titular").value ='';
}
    
