const confirmar = () =>{
    let descricao = document.querySelector("#descricao").value;
    let geraFinanceiro = document.querySelector("#financeiro").checked;
    geraFinanceiro = (geraFinanceiro) ? 1 : 0;
    let inativo = document.querySelector("#inativo").checked;
    inativo = (inativo) ? 1 : 0;
    let codigo = document.querySelector("#cod").value;
    let origem = document.querySelector("#origem").value;
    if(descricao == ''){
        alert("Preencha todos os campos");
        document.querySelector("#descricao").style.borderColor = "red";
        return;
    }
    if(origem=='#'){
        alert("Preencha todos os campos");
        document.querySelector("#origem").style.borderColor = "red";
        return; 
    }
    
    let dados = {
        codigo: codigo,
        descricao: descricao,
        geraFinanceiro: geraFinanceiro,
        inativo: inativo,
        origem:origem
    }

    fetch("/owlsoftware/modulos/cadastro/tipo_entrada/cadastro/controllers/cadastro.php",{
        method:"POST",
        body: JSON.stringify(dados),
        headers: {'Content-type' : 'Application/JSON'}
    }).then((response)=>{
        return response.text();
    }).then((text)=>{
        alert(text);
        window.location.reload();
    }).catch((e)=>{
        alert("Erro ao conectar ao servidor. \n" + e);
    })
}