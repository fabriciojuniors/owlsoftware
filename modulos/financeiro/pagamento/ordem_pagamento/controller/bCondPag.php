<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM condicao_pagamento WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if($query){
        while($row = mysqli_fetch_array($query)){
            @$condicao[] = $row;
        }
        echo json_encode(@$condicao);
    }
?>