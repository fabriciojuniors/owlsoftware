function permissoes(usuario, modulos){
    dvTelas = document.getElementById("dvtelas");
    dvTelas.innerHTML = '';
    if(usuario == '' || modulos == ''){
        alert("Preencha todos os campos");
    }else{
        var dados = {
            usuario : usuario,
            modulos : modulos
        }
        fetch("/owlsoftware/modulos/adm/permissoes/controller/carregaPermissao.php",{
            method: "POST",
            body: JSON.stringify(dados),
            headers: {'Content-Type': 'application/json'}
        }).then(function(response){
            return response.text();
        }).then(function(text){
            //console.log(text);
            if(text == 'null'){
                alert("Nenhuma tela cadastrada para o módulo selecionado");
            }else{
                telas = JSON.parse(text);
                telas.forEach(t => {
                    conteudo = dvTelas.innerHTML;
                    if(t[1] == 1){
                        impressao = "<input type='checkbox' checked name='"+t[0]+"' id='"+t[0]+"'><label for='"+t[0]+"'>"+t[0].split("_").join(" ").toUpperCase()+"</label> <br>";
                    }else{
                        impressao = "<input type='checkbox' name='"+t[0]+"' id='"+t[0]+"'><label for='"+t[0]+"'>"+t[0].toUpperCase()+"</label> <br>";
                    }
                    
                    dvTelas.innerHTML = conteudo + impressao;
                });
            }
        }).catch(function(error){
            alert(error);
        })
    }
}