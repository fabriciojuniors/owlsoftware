<?php

include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $sql = "SELECT * FROM produto WHERE id = $dados[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $produtos = mysqli_fetch_array($query);

    $produto[] = array(
        "id" => $produtos['id'],
        "cod" => $produtos['cod'],
        "tprod" => $produtos['tipo_produto'],
        "descricao" =>$produtos['descricao'],
        "referencia" =>$produtos['referencia'],
        "gprod" =>$produtos['grupo_produto'],
        "marca" =>$produtos['marca'],
        "dt_criacao"=>$produtos['dt_criacao'],
        "dt_alteracao"=>$produtos['dt_alteracao'],
        "inativo" =>$produtos['inativo'],
        "preco_max"=>$produtos['preco_max'],
        "preco_min"=>$produtos['preco_min'],
        "cor"=>$produtos['cor']
        );  
    $produtoJson = json_encode($produto);
    echo $produtoJson
?>