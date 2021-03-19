var corpo = document.getElementById("conteudo");
window.addEventListener("load", Dados());

function Dados(){
    carregaTP();
    carregaGP();
    carregaMarca();
    //carregaTamanho();
    mascara();
}

function mascara(i){
        var v = i.value.replace(/\D/g,'');
        v = (v/100).toFixed(2) + '';
        v = v.replace(".", ",");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
        i.value = v;

}
function carregaTP(){
    fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/carregaTP.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        let tps = JSON.parse(text);
        tps.forEach(tp => {
            if(tp.inativo != 1){
                let x = document.getElementById("selecttprod");
                let option = document.createElement("option");
                option.value = tp.id;
                option.text = tp.descricao;
                x.add(option);
            }
        });
    })
}
function carregaGP(){
    fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/carregaGP.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        let tps = JSON.parse(text);
        tps.forEach(tp => {
            if(tp.inativo != 1){
                let x = document.getElementById("selectgprod");
                let option = document.createElement("option");
                option.value = tp.id;
                option.text = tp.descricao;
                x.add(option);
            }
        });
    })
}

function carregaMarca(){
    fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/carregaMarca.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        let tps = JSON.parse(text);
        tps.forEach(tp => {
            if(tp.inativo != 1){
                let x = document.getElementById("selectmarca");
                let option = document.createElement("option");
                option.value = tp.id;
                option.text = tp.descricao;
                x.add(option);
            }
        });
    })
}

function carregaTamanho(){
    fetch("/owlsoftware/modulos/cadastro/produto/cadastro/controller/carregaTamanho.php")
    .then(function(response){
        return response.text();
    }).then(function(text){
        let tps = JSON.parse(text);
        tps.forEach(tp => {
            if(tp.inativo != 1){
                let x = document.getElementById("tamanho");
                let option = document.createElement("option");
                option.value = tp.id;
                option.text = tp.descricao;
                x.add(option);
            }
        });
    })
}