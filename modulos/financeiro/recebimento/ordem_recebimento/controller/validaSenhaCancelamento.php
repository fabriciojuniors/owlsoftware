<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT *  FROM parametros_financeiros WHERE id = 1";
    $query = mysqli_query($link, $sql);

    $row = mysqli_fetch_array($query);
    $resultado = json_encode($row);

    echo $resultado;