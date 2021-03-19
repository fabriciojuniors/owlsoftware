<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM tipo_produto WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $tipos[] = $row;
        
    };
    $tiposJson = json_encode($tipos);
    echo $tiposJson;
?>