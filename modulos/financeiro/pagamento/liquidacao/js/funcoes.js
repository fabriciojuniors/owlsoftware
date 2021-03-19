var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados2());

function carregaDados2(){
    validaFiltro();
    pesquisar();
}
function pesquisar(){
    const formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
      })
    var divResultado = document.getElementById("resultadoOR");
    var movimento = document.getElementById("movimento").checked;
    if(movimento){
        var dados ={
            filtro: document.getElementById("opcaoFiltro").value,
            buscar: document.getElementById("filtro").value
        }
        fetch("/owlsoftware/modulos/financeiro/pagamento/liquidacao/controller/carregaOPMovto.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-type': 'Application/json'}  
        }).then(function(response){
            return response.text();
        }).then(function(text){
            if(text == 0){
                console.log("Nenhum título");
                divResultado.innerHTML = "<div class='alert alert-danger' role='alert'>Nenhum registro localizado!</div>";
            }else{
                document.getElementById("dadosMovto").style.display = 'none';
                divResultado.innerHTML = "<table class=' table table-sm table-striped' id='tabelaResultado'><thead><th>N° OP/Parcela</th><th>Fornecedor</th><th>Valor Movimentação</th><th>Data Movimentação</th><th>Tipo movto. Financeiro</th><th>Excluir?</th></thead>";
                var tabela = document.getElementById("tabelaResultado");
                var resultado = JSON.parse(text);
                resultado.forEach(m => {
                    var linha = tabela.insertRow(1);
                    var col1 = linha.insertCell(0);
                    var col2 = linha.insertCell(1);
                    var col3 = linha.insertCell(2);
                    var col4 = linha.insertCell(3);
                    var col5 = linha.insertCell(4);
                    var col6 = linha.insertCell(5);
                    col1.innerHTML = m[1] + "/" + m[2];
                    col2.innerHTML = m[3];
                    col3.innerHTML = formatter.format(m[5])
                    col4.innerHTML = m[4].split("-").reverse().join("/");
                    col5.innerHTML = m[6];
                    col6.innerHTML = "<a onclick='excluir("+m[0]+")' style='margin-left: 20%'><i class='far fa-trash-alt'></i></a>";
                    
                });
            }

        }).catch(function(error){
            alert(error);
        })

    }else{
        var dados ={
            filtro: document.getElementById("opcaoFiltro").value,
            buscar: document.getElementById("filtro").value
        } 
        
        fetch("/owlsoftware/modulos/financeiro/pagamento/liquidacao/controller/carregaOP.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-type': 'Application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            //console.log(text);
            if(text == 0){
                divResultado.innerHTML = "<div class='alert alert-danger' role='alert'>Nenhum registro localizado!</div>";
                document.getElementById("qtdTitulos").value = '';
            }else{
                document.getElementById("dadosMovto").style.display = '';
                var data = new Date();
                var dia = data.getDate();
                var mes = data.getMonth();
                var ano = data.getFullYear();
		        mes = (mes < 10) ? mes + 1 : mes;
                mes = (mes < 10) ? "0" + mes : mes;
                dia = (dia < 10) ? "0" + dia : dia;
                var diaH = ano + "-" + mes + "-" + dia;
                console.log(diaH);
                var parcelas = JSON.parse(text);
                divResultado.innerHTML = "<table class=' table table-sm table-striped' id='tabelaResultado'><thead><th>N° OP/Parcela</th><th>Fornecedor</th><th>Vencimento</th><th>Valor</th><th>Valor Saldo</th><th>Valor Movimentação</th><th>Data Movimentação</th><th>Movimentar?</th></thead>";
                var tabela = document.getElementById("tabelaResultado");
                var script = document.createElement("script");
                script.src = "https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js";
                document.body.appendChild(script);
                var q = 0;
                parcelas.forEach(p => {
                    q++;
                    var linha = tabela.insertRow(1);
                    var col1 = linha.insertCell(0);
                    var col2 = linha.insertCell(1);
                    var col3 = linha.insertCell(2);
                    var col4 = linha.insertCell(3);
                    var colSaldo = linha.insertCell(4);
                    var col5 = linha.insertCell(5);
                    var col6 = linha.insertCell(6);
                    var col7 = linha.insertCell(7);
                    col1.innerHTML = p[7] + "/" + p[2];
                    col1.id = "op-parcela-"+p[0];
                    col2.innerHTML = p[3];
                    col3.innerHTML = p[4].split("-").reverse().join("/");
                    col4.innerHTML = formatter.format(p[5]);
                    col5.innerHTML = "<input type='text' value='"+p[6].split(".").join(",")+"' data-mask=000.000.000.000.000,00 data-mask-reverse=true style='width: 150px; ' id='valorMovimentacao-"+p[0]+"' class='form-control campos'>";
                    col6.innerHTML = "<input type='date' name='data-hoje' value='"+diaH+"' style='width: 150px;' id='dataMovimentacao-"+p[0]+"' class='form-control campos'>";
                    col7.innerHTML = "<div class='custom-control custom-switch'><input type='checkbox' class=' custom-control-input' id='movimentar-"+q+"'><label style='margin-left:20%' class='custom-control-label' for='movimentar-"+q+"'></label> <input type='hidden' id='parcelaID"+q+"' value='"+p[0]+"' </div>";
                    //saldo
                    colSaldo.innerHTML = formatter.format(p[6]);
                    
                });
                
                document.getElementById("qtdTitulos").value = q;
            }
    
        }).catch(function(error){
            alert(error);
        })
    }   
}

function excluir(id){
    var dados = {
        id : id,
        usuario: localStorage.getItem("usuario")
    }

    fetch("/owlsoftware/modulos/financeiro/pagamento/liquidacao/controller/excluirMovto.php",{
        method: "POST",
        body: JSON.stringify(dados),
        headers: {'Content-type': 'Application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        alert(text);
        pesquisar();
    }).catch(function(error){
        alert(error);
    })
}

function salvarMovto(){
    var erro = true;
    setTimeout(() => {
        document.getElementById("erroMovto").style.display = "none";
        document.getElementById("loadSalvar").style.display = "none";
        document.getElementById("salvarMovto").style.pointerEvents = "all";
        document.getElementById("erroMovto").innerHTML = '';
        pesquisar();
    }, 5000);
    var qtd = document.getElementById("qtdTitulos").value;
    if(qtd != ''){
        var conta = document.getElementById("sconta").value;
        var tpmovto = document.getElementById("stpmovto").value;
        var selecionado = false
        for(i = 1; i<= qtd ; i++){
            var movimentar = document.getElementById("movimentar-"+i).checked;
            if(movimentar === true){
                selecionado = true;
                if(conta == '#' || tpmovto == '#'){
                    alert("Preencha todos os campos");
                    if(conta == '#'){
                        document.getElementById("sconta").style.borderColor = 'red';
                    }
                    if(tpmovto == '#'){
                        document.getElementById("stpmovto").style.borderColor = 'red';
                    }
                }
                else{
                    document.getElementById("sconta").style.borderColor = '';
                    document.getElementById("stpmovto").style.borderColor = '';
                    document.getElementById("loadSalvar").style.display = "";
                    document.getElementById("salvarMovto").style.pointerEvents = "none";
                    
                    var parcelaID = document.getElementById("parcelaID"+i).value;
                    var valorMovimentacao = document.getElementById("valorMovimentacao-"+parcelaID).value;
                    valorMovimentacao = valorMovimentacao.split(".").join("");
                    valorMovimentacao = valorMovimentacao.split(",").join(".");
                    var dataMovimentacao = document.getElementById("dataMovimentacao-"+parcelaID).value;
                    var opparcela = document.getElementById("op-parcela-"+parcelaID).innerText;
                    var usuario = localStorage.getItem("usuario");
                    var dados = {
                        parcelaID: parcelaID,
                        valorMovimentacao: valorMovimentacao,
                        dataMovimentacao: dataMovimentacao,
                        conta: conta,
                        tpmovto: tpmovto,
                        opparcela: opparcela,
                        usuario: usuario
                    }
                    
                    fetch("/owlsoftware/modulos/financeiro/pagamento/liquidacao/controller/movimentaOP.php",{
                        method: "POST",
                        body: JSON.stringify(dados),
                        headers: {'Content-type': 'Application/json'}
                    }).then(function(response){
                        return response.text();
                    }).then(function(teste){
                        
                        if(teste == "sucesso"){
                            erro = false;
                            document.getElementById("erroMovto").style.display = "block";
                            document.getElementById("erroMovto").classList.remove('alert-danger');
                            document.getElementById("erroMovto").classList.add('alert-success');
                            var conteudo = document.getElementById("erroMovto").innerHTML;
                            conteudo = conteudo.replace("Salvo com sucesso. <br>", "");
                            document.getElementById("erroMovto").innerHTML = "Salvo com sucesso. <br>" + conteudo;
                        }else{
                            document.getElementById("erroMovto").style.display = "block";
                            document.getElementById("erroMovto").classList.add('alert-danger');
                            var conteudo = document.getElementById("erroMovto").innerHTML;
                            document.getElementById("erroMovto").innerHTML = conteudo + teste + "<br>";
                            erro = true;
                        }

                    }).catch(function(error){
                        alert(error);
                    })
                }
            }
        }
        if(!selecionado){
            alert("Selecione um título para salvar a movimentação.")
        }
    }else{
        alert("Nenhum título carregado, clique em Pesquisar para localizar as parcelas desejadas.");
    }

}

function validaFiltro(){
    var filtro = document.getElementById("opcaoFiltro").value;
    if(filtro == "#"){
        document.getElementById("filtro").value ='';
        document.getElementById("filtro").disabled = true;
    }else{
        document.getElementById("filtro").value ='';
        document.getElementById("filtro").disabled = false;
    }
}