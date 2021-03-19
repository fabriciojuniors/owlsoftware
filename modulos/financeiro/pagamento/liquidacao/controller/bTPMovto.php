<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT id, descricao FROM tp_movto_financeiro WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $result[] = $row;
    }
    $resultj = json_encode($result);
    echo $resultj;