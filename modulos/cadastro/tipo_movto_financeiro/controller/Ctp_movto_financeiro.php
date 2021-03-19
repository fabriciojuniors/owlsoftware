<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM tp_movto_financeiro ORDER BY id DESC";
    $query = mysqli_query($link, $sql);

    while($row = mysqli_fetch_array($query)){
        $result[] = $row;
    }
    echo json_encode($result);