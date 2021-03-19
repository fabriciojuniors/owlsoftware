var corpo = document.getElementById("conteudo");
window.addEventListener("load", carregaDados());

function carregaDados() {
    carregaFinanceiro();
    carregaFaturamento();
}

function habilitaSenha(check) {
    if (check) {
        document.getElementById("dvSenhaCancelamento").style.display = 'block'
    } else {
        document.getElementById("senhaCancelamento").value = '';
        document.getElementById("dvSenhaCancelamento").style.display = 'none';

    }
}

function carregaFaturamento() {
    fetch("/owlsoftware/modulos/adm/parametros/controller/carregaFaturamento.php", {
        Headers: { 'Content-type': 'Application/json' }
    }).then(function(response) {
        return response.text();
    }).then(function(text) {
        var parametro = JSON.parse(text);
        parametro.forEach(p => {
            if (p.id == 1) {
                document.getElementById("senhaCancelamentoFat").value = p.valor;

            }
        });

    }).catch(function(error) {
        alert(error);
    })
}

function carregaFinanceiro() {
    fetch("/owlsoftware/modulos/adm/parametros/controller/carregaFinanceiro.php", {
        Headers: { 'Content-type': 'Application/json' }
    }).then(function(response) {
        return response.text();
    }).then(function(text) {
        var parametro = JSON.parse(text);

        parametro.forEach(p => {
            if (p.id == 1) {
                if (p.valor == 1) {
                    document.getElementById("1").checked = true;
                    habilitaSenha(true);
                    document.getElementById("senhaCancelamento").value = p.valor_adicional;
                } else {
                    document.getElementById("1").checked = false;
                }
            }
        });

    }).catch(function(error) {
        alert(error);
    })
}

function salvarFinanceiro() {
    var esenha = document.getElementById("1").checked;
    if (esenha) {
        esenha = 1;
        var senha = document.getElementById("senhaCancelamento").value;
    } else {
        esenha = 0;
    }
    if (senha == '') {
        alert("Preencha todos os campos");
        document.getElementById("senhaCancelamento").style.borderColor = "red";
    } else {
        var dados = {
            esenha: esenha,
            senha: senha
        };
        fetch("/owlsoftware/modulos/adm/parametros/controller/salvarFinanceiro.php", {
            method: "POST",
            body: JSON.stringify(dados),
            Headers: { 'Content-type': 'Application/json' }
        }).then(function(response) {
            return response.text();
        }).then(function(text) {
            alert(text);
            window.location.reload();
        }).catch(function(error) {
            alert(error);
        })
    }

}

function salvarFaturamento() {
    if (!document.querySelector("#senhaCancelamentoFat").value) {
        alert("Preencha todos os campos.");
        return;
    }

    let dados = {
        senha: document.querySelector("#senhaCancelamentoFat").value
    }

    fetch("/owlsoftware/modulos/adm/parametros/controller/salvarFaturamento.php", {
        method: "POST",
        body: JSON.stringify(dados),
        Headers: { 'Content-type': 'Application/json' }
    }).then(function(response) {
        return response.text();
    }).then(function(text) {
        alert(text);
        window.location.reload();
    }).catch(function(error) {
        alert(error);
    })

}