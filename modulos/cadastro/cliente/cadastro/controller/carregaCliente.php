<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $id = $dados['id'];

    $sql = "SELECT clientes.*, cidade.nome as cidadeNome FROM clientes INNER JOIN cidade WHERE cidade.id = clientes.cidade AND clientes.id = $id";
    $query = mysqli_query($link, $sql);
    while(@$row = mysqli_fetch_array($query)){
        @$result[] = $row;
    };
    echo @json_encode($result);