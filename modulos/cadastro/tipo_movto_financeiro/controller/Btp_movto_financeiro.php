<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM tp_movto_financeiro WHERE id = $dados[cod]";
    $query = mysqli_query($link, $sql);

    while($row = mysqli_fetch_array($query)){
        $result[] = $row;
    }
    $resultJ = json_encode($result);
    echo $resultJ;