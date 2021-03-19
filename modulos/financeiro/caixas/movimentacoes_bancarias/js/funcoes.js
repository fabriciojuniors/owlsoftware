var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());

function carregaDados(){
    carregaConta();
}
function carregaConta(){
    fetch("/owlsoftware/modulos/financeiro/pagamento/ordem_pagamento/controller/bConta.php",{
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

function pesquisar(){
    
    const formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
      })
    var conta = document.getElementById("conta").value;
    var iemissao = document.getElementById("iemissao").value;
    var femissao = document.getElementById("femissao").value;
    var dv = document.getElementById("resultado");
    if(conta == "#"){
        alert("Preencha todos os campos");
        document.getElementById("conta").style.borderColor = "red";
    }else{
        document.getElementById("conta").style.borderColor = "";
        var dados = {
            conta: conta,
            iemissao: iemissao,
            femissao: femissao
        };
        fetch("/owlsoftware/modulos/financeiro/caixas/movimentacoes_bancarias/controller/movimentacao.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            //console.log(text);
            if(text == 0 || text === 0){
                dv.innerHTML = "Nenhuma movimentação localizada com os filtros informados.";
            }else{
                var resultado = JSON.parse(text);
                var tamanho = resultado.length;
                dv.innerHTML = "<table class='table table-sm' id='tabelaResultado'><thead><th>Origem Docto</th><th>N° Docto</th><th>Cliente/Fornecedor</th><th>Data</th><th>Movimentação</th><th>Observação</th><th>Valor</th><th>Saldo Bancário</th></thead></table>"
                var tabela = document.getElementById("tabelaResultado");
                for (let i = 0; i < resultado.length; i++) {
                    var m = resultado[i];
                    var linha = tabela.insertRow(-1);
                    var colOrigem = linha.insertCell(0);
                    var colNParcela = linha.insertCell(1);
                    var colCliente = linha.insertCell(2);
                    var colData = linha.insertCell(3);
                    var colMovto = linha.insertCell(4);
                    var colObs = linha.insertCell(5);
                    var colValor = linha.insertCell(6);
                    var colSaldo = linha.insertCell(7);
                    colOrigem.innerHTML = m[0];
                    colNParcela.innerHTML = m[2] + " / " + m[3];
                    colCliente.innerHTML = m[1];
                    colData.innerHTML = m[4].split("-").reverse().join("/");
                    colMovto.innerHTML = m[6];
                    colValor.innerHTML = formatter.format(m[5]);
                    colObs.innerHTML = m[7];

                    if(i === 0){
                        if(m[0] == "OR"){
                            colSaldo.innerHTML = formatter.format(m[5]);
                        }else{
                            colSaldo.innerHTML = formatter.format(m[5]);
                            colSaldo.style.color = "red";
                        }
                    }else{
                        var soma =0;
                        var menos =0;
                        var saldo = 0;
                        mAnt = resultado[i-1];
                        for(j=0; j<=i; j++){
                            var mAntes = resultado[j];
                            if(mAntes[0] == "OR"){
                                soma += parseFloat(mAntes[5]);
                            }else{
                                menos += parseFloat(mAntes[5]);
                            }
                        }
                        saldo = soma-menos;
                        if(saldo < 0){
                            colSaldo.innerHTML = formatter.format(saldo);
                            colSaldo.style.color = "red";
                        }else{
                            colSaldo.innerHTML = formatter.format(saldo);
                        }
                        
                    }
                }
                conteudo = dv.innerHTML;
                dv.innerHTML = conteudo + "<button class='btn btn-square btn-success' style='float: right' onclick=imprimir("+conta+",'"+iemissao+"','"+femissao+"')>Imprimir</teste>"
            }
        }).catch(function(error){
            console.log(error);
        })
    }
}

function imprimir(conta, iemissao, femissao){
    window.open('/owlsoftware/modulos/financeiro/caixas/movimentacoes_bancarias/controller/imprimir.php?conta='+conta+'&iemissao='+iemissao+'&femissao='+femissao+'','_system','location=yes');
}