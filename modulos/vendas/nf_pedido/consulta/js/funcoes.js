window.addEventListener("load", function(){
    dados = {pagina: 1, 
        qnt_result_pg: 6,
        pedido: document.getElementById("numPedido").value,
        nota: document.getElementById("numNF").value,
        cliente: document.getElementById("codCli").value,
        inicio: document.getElementById("iemissao").value,
        fim: document.getElementById("femissao").value,
        descAsc : document.getElementById("orderDesc").value
    };
    listar(dados);
});

function pesquisarNota(pagina, order, descAsc){
    if(order != undefined){
        document.getElementById("order").value = order;    
    }
    if(descAsc != undefined){
        document.getElementById("orderDesc").value = descAsc;
    }
    order2 = document.getElementById("order").value;
    descAsc2 = document.getElementById("orderDesc").value;

    dados = {pagina: pagina, 
        qnt_result_pg: 6,
        pedido: document.getElementById("numPedido").value,
        nota: document.getElementById("numNF").value,
        cliente: document.getElementById("codCli").value,
        inicio: document.getElementById("iemissao").value,
        fim: document.getElementById("femissao").value,
        order: order2,
        descAsc : descAsc2
    };
        listar(dados);
}

function listar(dados){
    console.log(dados);
    fetch('/owlsoftware/modulos/vendas/nf_pedido/consulta/controller/listar.php',{
        method: 'POST',
        body: JSON.stringify(dados),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response){
        return response.text();
    }).then(function(text){
        document.getElementById('pesquisarNF').innerHTML = text;
    }).catch(function(error){
        console.log(error);
    })
};

function editarNF(numero, ref){
    if(ref == "0"){
        window.location.href = "/owlsoftware/modulos/index.php?pag=nf_pedido&numero="+numero;
    }else{
        window.location.href = "/owlsoftware/modulos/index.php?pag=nf_devolucao&numero="+numero;
    }
    
}

function buscarClie(cod){
    var dados = {
        cod: cod
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteE.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        ////console.log(text);
        if(text == 'null'){
            alert("N??o foi poss??vel localizar cliente com o c??digo informado.");
            document.getElementById("codCli").value = '';
            document.getElementById("nomeCli").value = '';
        }else{
            var cliente = JSON.parse(text);
            cliente.forEach(c => {
                document.getElementById("codCli").value = c.id;
                document.getElementById("nomeCli").value = c.nome;
            });
        }
    }).catch(function(error){
        //console.log(error);
    });

}
function pesquisarCli(){
    var CPF_CNPJ = document.getElementById("cpfcnpj").value;
    var nome = document.getElementById("nome").value;
    var dados = {
        cpfcnpj: CPF_CNPJ,
        nome: nome
    }
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bClienteModal.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        
        var resultado = document.getElementById("divResultado")
        if(text == 'null'){
            resultado.innerHTML = "N??o foi poss??vel localizar clientes cadastrados.";
        }else{
            var clientes = JSON.parse(text);
            resultado.innerHTML = "<table id='tabelaResultado' class='table table-sm'><thead><th>C??digo</th><th>CPF/CNPJ</th><th>Nome</th><th>#</th></thead>";
            var tabela = document.getElementById("tabelaResultado");
            clientes.forEach(c => {
                var linha = tabela.insertRow(-1);
                var col1 = linha.insertCell(0);
                var col2 = linha.insertCell(1);
                var col3 = linha.insertCell(2);
                var col4 = linha.insertCell(3);
                col1.innerHTML = c.id;
                col2.innerHTML = c.CPF_CNPJ;
                col3.innerHTML = c.nome; 
                col4.innerHTML = "<a onclick='buscarClie("+c.id+")' data-toggle='modal' data-target='#modalCliente'><i class='fas fa-check'></i></a>"
            });
        }
    }).catch(function(error){
        //console.log(error);
    })
}

function imprimirNF(numero){
    window.open("/owlsoftware/modulos/vendas/nf_pedido/consulta/controller/imprimirNF.php?numero="+numero, '_system','location=yes');
}

function preencherEmail(email, nota){
    document.getElementById("emailCli").value = email;
    document.getElementById("mensagem").value = "Voc?? est?? recebendo este e-mail referente a nota fiscal n??"+nota;
    document.getElementById("notaEnviar").value = nota;
}

function enviarEmail(){
    document.getElementById("btnEnviarEmail").innerHTML = "<i id='loaderEnvio' style='margin-right: 15px' class='fa fa-circle-o-notch fa-spin'></i>Enviar";
    document.getElementById("btnEnviarEmail").disabled = true;
    let email = document.getElementById("emailCli").value;
    let msg = document.getElementById("mensagem").value;
    let nota = document.getElementById("notaEnviar").value;
    if(email && msg){
        let dados  = {
            email: email,
            msg: msg,
            nota: nota
        }
        fetch('/owlsoftware/modulos/vendas/nf_pedido/enviarNF/envioConsulta.php',{
            method: 'POST',
            body: JSON.stringify(dados),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            return response.text();
        }).then(function(text){
            if(text == ''){
                window.location.reload();
                alert("Enviado com sucesso.");
                
            }else{
                alert(text);
            }
            //document.getElementById("fecharmodal").click();
        }).catch(function(error){
            console.log(error);
        })
    }else{
        alert("Preencha todos os campos.");
    }
    
}