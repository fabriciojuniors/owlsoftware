<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $qtd = count($dados);
    $erro = "false";
    for ($i=1; $i < $qtd; $i++) { 
        $sql = "UPDATE permissoes_acesso SET liberado = 1 WHERE usuario = $dados[0] AND tela = (SELECT id from telas WHERE nome = '$dados[$i]')";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if(!$query){
            $erro = "true";
        }
    }
    echo $erro;