$(document).ready(function($){
    carregaDados();
    $('#valorTot').mask('000.000.000.000.000,00', {reverse: true});
    $('#valorParcela').mask('000.000.000.000.000,00', {reverse: true});
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
    
    
})

// var corpo = document.getElementById("conteudo");
// window.addEventListener("load", );
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
        if(text == 'null'){
            alert("Não foi possível localizar cliente com o código informado.");
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
        console.log(error);
    });

}
function carregaDados(){
    let url = new URL(location.href);
    let id = url.searchParams.get("id");
    console.log(id);
    if(id != ''){
        
        dados = {
            id: id
        };
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/carregaOR.php" , {
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}}
        ).then(function(response){
            return response.text();
        }).then(function(text){
            setTimeout(() => {
                var p = JSON.parse(text);
                document.getElementById("selecaoCli").disabled = true;
                document.getElementById("nor").value = p[0];
                document.getElementById("seqnor").value = p[1];
                buscarClie(p[2]);
                document.getElementById("codCli").disabled = true;
                document.getElementById("emissao").value = p[3];
                document.getElementById("emissao").disabled = true;
                document.getElementById("vencimento").value = p[4];
                (p[11] == 1)? document.getElementById("vencimento").disabled = false : document.getElementById("vencimento").disabled = "true";
                document.getElementById("valorTot").value = p[5];
                document.getElementById("valorTot").disabled =true;
                document.getElementById("valorParcela").value = p[6];
                (p[11] == 1)? document.getElementById("valorParcela").disabled =false : document.getElementById("valorParcela").disabled ="true";
                document.getElementById("scondpag").value = p[7];
                document.getElementById("scondpag").disabled = true;
                document.getElementById("sformapag").value = p[8];
                document.getElementById("sformapag").disabled = true;
                document.getElementById("observacoes").value = p[10];
                carregaParcelas(id);
               
            }, 100);
           
           
        })

       
    }
    
    carregaCondPag();
    carregaFormaPag();
    //carregaConta();
    if(document.getElementById("nor").value == ''){
        document.getElementById("verComentario").title = "Desabilitado. É necessário abrir uma ordem de recebimento para visualizar comentário.";
        
    }else{
        console.log("oi");
        document.getElementById("verComentario").style.pointerEvents = "none";
    }
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
            resultado.innerHTML = "Não foi possível localizar clientes cadastrados.";
        }else{
            var clientes = JSON.parse(text);
            resultado.innerHTML = "<table id='tabelaResultado' class='table table-sm'><thead><th>Código</th><th>CPF/CNPJ</th><th>Nome</th><th>#</th></thead>";
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
                col4.innerHTML = "<a onclick='cliente("+c.id+")' data-toggle='modal' data-target='#modalCliente'><i class='fas fa-check'></i></a>"
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}

function confirmar(){
    var nor = document.getElementById("nor").value;
    var seqnor = document.getElementById("seqnor").value;
    var cliente = document.getElementById("codCli").value;
    var emissao = document.getElementById("emissao").value;
    var valor = document.getElementById("valorTot").value;
    valor = valor.split('.').join("");
    valor = valor.replace(',', '.');
    var condicao = document.getElementById("scondpag").value;
    var formapag = document.getElementById("sformapag").value;
    //var conta = document.getElementById("conta").value;
    var obs = document.getElementById("observacoes").value;
    //console.log(valor);
    if(nor !=''){
        atualizar();
    }else{
        if(cliente == '' || emissao == '' || valor == '' || condicao == '#' || formapag == '#'){
            alert("Preencha todos os campos.");
            if(cliente == ''){
                document.getElementById("codCli").style.borderColor = 'red';
            }
            if(emissao == ''){
                document.getElementById("emissao").style.borderColor ='red';
            }
            if(valor == ''){
                document.getElementById("valorTot").style.borderColor = 'red';
            }
            if(condicao == '#'){
                document.getElementById("scondpag").style.borderColor = 'red';
            }
            if(formapag == '#'){
                document.getElementById("sformapag").style.borderColor = 'red';
            }
            
        }else{
            var dados = {
                cliente: cliente,
                emissao: emissao,
                valor: valor,
                condicao: condicao,
                formapag: formapag,
                obs: obs
            }
            console.log(dados)
            fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/ordemRecebimento.php",{
                method: "POST",
                body: JSON.stringify(dados),
                headers: {'Content-Type': 'application/json'}
            }).then(function(response){
                return response.text();
            }).then(function(text){
                var resultado = text.split("/");
                alert(resultado[0]);
                window.location.href = "/owlsoftware/modulos/index.php?pag=OR&id="+resultado[1];
            }).catch(function(error){
                alert(error);
            })
    
        }
    }

}

function atualizar(){
    var nor = document.getElementById("nor").value;
    var seqnor = document.getElementById("seqnor").value;
    var vencimento = document.getElementById("vencimento").value;
    var valorParcela = document.getElementById("valorParcela").value;
    var obs = document.getElementById("observacoes").value;
    valorParcela = valorParcela.split('.').join('');
    valorParcela = valorParcela.replace(',', '.');
    console.log(valorParcela);
    var dados = {
        nor: nor,
        seqnor: seqnor,
        vencimento: vencimento,
        valorParcela: valorParcela,
        obs: obs 
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/aParcela.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        alert("Registro atualizado com sucesso.");
        //console.log(text);
        carregaParcelas(text);
    }).catch(function(error){
        console.log(error);
    })

}

function carregaParcelas(id){
    var dados = {
        id: id
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/cParcelas.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var resultado = JSON.parse(text);
        var resultadoDiv = document.getElementById("resultado");
        //console.log(resultado);
        resultadoDiv.innerHTML = "<table class='table table-striped  table-sm' id='tabelaResultado'><thead><th>Número</th><th>Vencimento</th><th>Valor</th><th>Status</th><th>#</th></thead></table>";
        tabela = document.getElementById("tabelaResultado");
        resultado.forEach(r => {
            var linha = tabela.insertRow(1);
            var col1 = linha.insertCell(0);
            var col2 = linha.insertCell(1);
            var col3 = linha.insertCell(2);
            var col5 = linha.insertCell(3);
            var col4 = linha.insertCell(4);
            col1.innerHTML = r[2];
            col2.innerHTML = r[4].split("-").reverse().join("/");
            col3.innerHTML = "R$"+r[5].split(".").join(",");
            col5.innerHTML = r.descricao;
            col4.innerHTML = "<a hrf onclick=editar("+r[0]+")> <i class='fas fa-edit'></i> </a>"
        });
    }).catch(function(error){
        console.log(error);
    })

}

function pesquisar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=busca_or"
}

function editar(id){
    var dados = {
        id: id
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/editarParcela.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var p = JSON.parse(text);
        document.getElementById("selecaoCli").disabled = true;
        document.getElementById("nor").value = p[0];
        document.getElementById("seqnor").value = p[1];
        buscarClie(p[2]);
        document.getElementById("codCli").disabled = true;
        document.getElementById("emissao").value = p[3];
        document.getElementById("emissao").disabled = true;
        document.getElementById("vencimento").value = p[4];
        (p[11] == 1) ? document.getElementById("vencimento").disabled = false : document.getElementById("vencimento").disabled = "true";
        document.getElementById("valorTot").value = p[5];
        document.getElementById("valorTot").disabled =true;
        document.getElementById("valorParcela").value = p[6].split(".").join(",");
        console.log(p[11]);
        (p[11] == 1)? document.getElementById("valorParcela").disabled =false : document.getElementById("valorParcela").disabled ="true";
        document.getElementById("scondpag").value = p[7];
        document.getElementById("scondpag").disabled = true;
        document.getElementById("sformapag").value = p[8];
        document.getElementById("sformapag").disabled = true;
        document.getElementById("observacoes").value = p[10];
    }).catch(function(error){
        console.log(error);
    })
}

function carregaConta(){
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bConta.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível carregar conta bancária.");
        }else{
            var condicao = JSON.parse(text);
            var select = document.getElementById("conta");
            condicao.forEach(c => {
                var opt = document.createElement("option");
                opt.value = c[1];
                opt.text = c[0] + " - (AG: " + c[2] + ", CONTA: " + c[3] + ")";
                select.append(opt);
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}

function carregaCondPag(){
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bCondPag.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível carregar condição de pagamento.");
        }else{
            var condicao = JSON.parse(text);
            var select = document.getElementById("scondpag");
            condicao.forEach(c => {
                var opt = document.createElement("option");
                opt.value = c.id;
                opt.text = c.descricao;
                select.append(opt);
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}

function carregaFormaPag(){
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bFormaPag.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível carregar forma de pagamento.");
        }else{
            var formas = JSON.parse(text);
            var select = document.getElementById("sformapag");
            formas.forEach(c => {
                var opt = document.createElement("option");
                opt.value = c.id;
                opt.text = c.descricao;
                select.append(opt);
            });
        }
    }).catch(function(error){
        console.log(error);
    })
}

function cliente(cod){
    var dados = {
        cod: cod
    };
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/bCliente.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'null'){
            alert("Não foi possível localizar cliente com o código informado.");
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
        console.log(error);
    });
}

function limpar(){
    window.location.href = "/owlsoftware/modulos/index.php?pag=OR";
}

function validaCancelamento(){
    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/validaSenhaCancelamento.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        var resultado = JSON.parse(text);
        if(resultado.valor == 1){
            document.getElementById("dvSenha").style.display = "block";
        }
    }).catch(function(error){
        alert(error);
    })  
}

function cancelar(){
    var opcao;
    var senha = document.getElementById("senha").value;
    var nor = document.getElementById("nor").value;
    var seqnor = document.getElementById("seqnor").value;
    var selecionada = document.getElementById("selecionada").checked;
    var todas = document.getElementById("todas").checked;
    var usuario = localStorage.getItem("usuario");
    var dados = {};
    if(nor ==''){
        alert("É necessário estar com uma ordem de recebimento aberta para efetuar o cancelamento. ");
        return;
    }else{
        if(selecionada){
            dados = {
                senha: senha,
                opcao: 1,
                nor: nor,
                seqnor: seqnor,
                usuario: usuario
            }
        }else if(todas){
            dados = {
                senha: senha,
                opcao: 2,
                nor: nor,
                usuario: usuario
            }
        }else{
            alert("Selecione uma opção para cancelamento. ");
        }
    }

    fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/cancelarOR.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 1){
            document.getElementById("senha").classList.add("is-invalid")
        }else{
            document.getElementById("senha").classList.remove("is-invalid")
            document.getElementById("senha").classList.add("is-valid")
            alert(text);
            window.location.reload();
        }
    }).catch(function(error){
        alert(error);
    })

}
function verificaComentario(){
    if(document.getElementById("nor").value == ''){
        alert("Selecione uma ordem de recebimento para visualizar os comentários.");
    }else{
        carregaComentario();
    }
}
function carregaComentario(){
    var nor  = document.getElementById("nor").value;
  
        var dados = {nor: nor};
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/carregaComentario.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            var dvTab = document.getElementById("tabComentarios");
            if(text == 0){
                dvTab.innerHTML = "<div class='alert alert-danger' role='alert'>Nenhum comentário localizado para a ordem de recebimento.</div>";
            }else{
                dvTab.innerHTML = "<table id='tbComentario' class='table table-sm table-striped'><thead><th>Data/Hora</th><th>Comentário</th><th>Usuário</th></thead>"
                var tab = document.getElementById("tbComentario");
                var comentarios = JSON.parse(text);
                comentarios.forEach(c => {
                    var linha = tab.insertRow(-1);
                    var col1 = linha.insertCell(0);
                    col1.style.width = "200px";
                    var col2 = linha.insertCell(1);
                    var col3 = linha.insertCell(2);
                    col3.style.width = "100px";
                    var data = c[0].split(" ");
                    col1.innerHTML = data[0].split("-").reverse().join("/") + " " + data[1];
                    col2.innerHTML = c[1];
                    col3.innerHTML = c[2];
                });
            }
        }).catch(function(error){
            alert(error);
        })
    

}

function addComentario(){
    var comentario = document.getElementById("comentario").value;
    var usuario = localStorage.getItem("usuario");
    var nor  = document.getElementById("nor").value;
    if(comentario == ''){
        alert("Informe um comentário.");
    }else{
        var dados = {
            comentario: comentario,
            usuario: usuario,
            nor : nor
        }
        fetch("/owlsoftware/modulos/financeiro/recebimento/ordem_recebimento/controller/addComentario.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            alert(text);
            carregaComentario();
        }).catch(function(error){
            alert(error);
        })
    }
}