var corpo = document.getElementById("conteudo");
window.addEventListener("load", function(){
    document.getElementById("atualizaDash").click();
});

function carregaDados2(){
    topCompradores();
    ganhosMensal();
    ganhosAnual();
}

function ganhosMensal(){
    var dv = document.getElementById("recMensal");
    dv.innerHTML = "";
    fetch("/owlsoftware/modulos/adm/parametros/controller/ganhosMensal.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 'nao'){
            dv.innerHTML = "Não foi posível obter os valores."
        }else{
            var resultado = JSON.parse(text);
            if(resultado[0]==null){
                dv.innerHTML = "<p style='font-size: 14px'>Não foi posível obter os valores.</p>"
            }else{
                dv.innerHTML = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'BRL' }).format(resultado[0]); //resultado[0].split(".").join(",");
            }
        }
    }).catch(function(error){
        console.log(error);
    })
}

function ganhosAnual(){
    var dv = document.getElementById("recAnual");
    dv.innerHTML = "";
    fetch("/owlsoftware/modulos/adm/parametros/controller/ganhosAnual.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
        if(text == 'nao'){
            dv.innerHTML = "Não foi posível obter os valores."
        }else{
            var resultado = JSON.parse(text);
            if(resultado[0]==null){
                dv.innerHTML = "<p style='font-size: 14px'>Não foi posível obter os valores.</p>"
            }else{
                dv.innerHTML = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'BRL' }).format(resultado[0]);
            }
        }
    }).catch(function(error){
        console.log(error);
    })
}

function topCompradores(){
    var dv = document.getElementById("listagem");
    dv.innerHTML = "";
    fetch("/owlsoftware/modulos/adm/parametros/controller/carregaDashBoard1.php",{
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        if(text == 1){
            dv.innerHTML = "Não foi possível carregar as informações.";
        }else{
            var cores = ['bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-primary'];
            var i = 0
            var resultado = JSON.parse(text);
            resultado.forEach(r => {
                conteudo = dv.innerHTML;
                dv.innerHTML = conteudo + "<h4 class='small font-weight-bold'>"+r[2]+" ("+((r[1]/r[0])*100).toFixed(2)+"%)<span class='float-right'>"+new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'BRL' }).format(r[1]) +"</span></h4>  <div class='progress mb-4'><div class='progress-bar "+cores[i]+"' role='progressbar' style='width: "+(r[1]/r[0])*100 +"%' aria-valuenow='30' aria-valuemin='0' aria-valuemax='100'></div></div>" ;
                i++
            });
            conteudo = dv.innerHTML;
            dv.innerHTML = conteudo + "Obs: O percentual apresentado é referente ao faturamento total."
        }
        
    }).catch(function(error){
        console.log(error);
    })
}