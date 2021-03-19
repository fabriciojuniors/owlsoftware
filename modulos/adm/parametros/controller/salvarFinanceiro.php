<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if(!isset($dados['senha'])){
        $sql = "UPDATE parametros_financeiros SET valor = $dados[esenha], valor_adicional = '' WHERE id = 1";
    }else{
        $sql = "UPDATE parametros_financeiros SET valor = $dados[esenha], valor_adicional = $dados[senha] WHERE id = 1";
    }

    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    if(mysqli_affected_rows($link)>0){
        echo "Salvo com sucesso.";
    }else{
        echo "Erro ao salvar alterações. " . mysqli_error($link);
    }