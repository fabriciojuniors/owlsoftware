function limpar(){
    document.getElementById("codigo").value = '';
    document.getElementById("descricao").value = '';
    document.getElementById("id").value = '';
    document.getElementById("codigo").removeAttribute("disabled");
    
}

function pesquisar(){
    window.location.href = "/owlsoftware/modulos/index.html?pag=cons_tipo_produto"
}
$(document).ready(function cadastrar(){


    $("#confirmar").click(function(){
       var id = $("#id").val();
       if (id != ''){
        var descricao = $("#descricao").val();
        var inativo = $("#inativo").is(':checked');
        if (descricao == ''){
            alert("Preencha todos os campos");
        } else{
        if(inativo){
            inativo = 1;
        } else{
            inativo = 0;
        }
        var data = "descricao="+descricao+"&inativo="+inativo+"&id="+id+"&data="+data_atualizacaoBD+"&usuario="+localStorage.getItem("usuario");
        $.ajax({
            type: "POST",
            url: "/owlsoftware/modulos/cadastro/tipo_produto/consulta/controllers/atualizar.php",
            data: data,
            success:  function(resultado){
                if(resultado == 1 || resultado == 0){
                    alert("Salvo com sucesso");
                    location.reload();
                } else{
                    alert("Erro ao salvar alteração \n "+ resultado);
                }
            },
            error: function(){
                alert("Erro ao salvar as alterações no registro.");
            }
        })
    }
            
       } else{
       var cod = $("#codigo").val();
       var descricao = $("#descricao").val();
       var inativo = $("#inativo").is(':checked');
 
       if(inativo){
           inativo = 1;
       } else{
           inativo = 0;
       }
       if(descricao != ''){
        if(cod==''){
            $.ajax({
                type: "POST",
                url: "/owlsoftware/modulos/cadastro/tipo_produto/cadastro/controllers/gerarCodigo.php",
                success: function(resultado){
                    var codigo = Number(resultado)+1;
                    var data = "cod="+codigo+"&descricao="+descricao+"&inativo="+inativo+"&usuario="+localStorage.getItem("usuario");
                    $.ajax({
                        type: "POST",
                        url: "/owlsoftware/modulos/cadastro/tipo_produto/cadastro/controllers/cadastrar.php",
                        data: data,
                        success: function(resultado){
                                if(resultado == 1){
                                    alert("Salvo com sucesso!");
                                    limpar();
                                    location.reload();
                                }else{
                                    alert("Erro ao salvar registro. \n Erro: "+resultado);
                                }
                        },
                        error: function(){
                            alert("Ocorreu um erro na rotina interna. Contate o suporte.");
                        }
                    })
                },
                error: function(){
                    alert("Erro ao gerar o código.");
                }
            })
        } else if(cod!=''){
            info = "cod="+cod;
            $.ajax({
                type: "POST",
                data: info,
                url: "/owlsoftware/modulos/cadastro/tipo_produto/cadastro/controllers/consultaCodigo.php",
                success: function(resultado){
                    if(resultado ==1 ){
                        alert("Código já utilizado.");
                    } else{
                        if(Number(cod)){
                            console.log(Number(cod));
                        }
                        var data = "cod="+cod+"&descricao="+descricao+"&inativo="+inativo;
                        $.ajax({
                            type: "POST",
                            url: "/owlsoftware/modulos/cadastro/tipo_produto/cadastro/controllers/cadastrar.php",
                            data: data,
                            success: function(resultado){
                                    if(resultado == 1){
                                        alert("Salvo com sucesso!");
                                        limpar();
                                        location.reload();
                                    }else{
                                        alert("Erro ao salvar registro. \n Erro: "+resultado);
                                    }
                            },
                            error: function(){
                                alert("Ocorreu um erro na rotina interna. Contate o suporte.");
                            }
                        })
                    }
                },
                error: function(){
                    alert("Erro ao validar o código informado.")
                }
            })
        }
       } else{
           alert("Preencha todos os campos.");
           document.getElementById("descricao").style.borderColor = "red";
       }
    }}); 
      
})