function salvarPermissao(){
    var usuario = document.getElementById("sUsuario").value;
    var desmarcados = [];
    desmarcados.push(usuario);
    var marcados = [];
    marcados.push(usuario);
    var inputs = document.getElementsByTagName("input");
    for (let i = 0; i < inputs.length; i++) {
        const item = inputs[i];
        if(item.type == "checkbox" && !item.checked){
            desmarcados.push(item.id);
        }else{
            marcados.push(item.id);
        }
    }
    desmarcadosJ = JSON.stringify(desmarcados);
    marcadosJ = JSON.stringify(marcados);
    desmarcadosF(desmarcadosJ);
    marcadosF(marcadosJ);

}
function marcadosF(dados){
    fetch("/owlsoftware/modulos/adm/permissoes/controller/marcados.php",{
        method: "POST",
        body: dados,
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
    }).catch(function(error){
        alert(error);
    })
}
function desmarcadosF(dados){
    fetch("/owlsoftware/modulos/adm/permissoes/controller/desmarcados.php",{
        method: "POST",
        body: dados,
        headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
        console.log(text);
    }).catch(function(error){
        alert(error);
    })
}
