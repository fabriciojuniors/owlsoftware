<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $sql = "SELECT * FROM parametros_faturamento";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while ($row = mysqli_fetch_array($query)) {
        $result[] = $row;
    }
    $resultJ = json_encode($result);
    echo $resultJ;