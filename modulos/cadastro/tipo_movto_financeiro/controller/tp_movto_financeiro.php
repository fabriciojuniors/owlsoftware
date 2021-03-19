<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['cod'] != '' ){
        atualizar($link, $dados);
    }else{
        cadastrar($link, $dados);
    }

    function cadastrar($link, $dados){
        $sql = "INSERT INTO tp_movto_financeiro(descricao, desconto, liquidacao, inativo) VALUES('$dados[descricao]', $dados[desconto], $dados[liquidacao], $dados[inativo])";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $linha = mysqli_affected_rows($link);
        $linha = ($linha > 0)? "Cadastro efetuado com sucesso." : "Erro ao realizar cadastro. ".mysqli_error($link);
        echo $linha;
    }
    function atualizar($link, $dados){
        $sql = "UPDATE tp_movto_financeiro SET descricao = '$dados[descricao]', desconto = $dados[desconto], liquidacao = $dados[liquidacao], inativo = $dados[inativo] WHERE id = $dados[cod]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $linha = mysqli_affected_rows($link);
        $linha = ($linha > 0)? "Registro atualizado com sucesso." : "Erro ao atualizar cadastro. ".mysqli_error($link);
        echo $linha;
    }