<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM tamanho WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $tamanhos[] = $row;
        
    };
    $tamanhosJson = json_encode($tamanhos);
    echo $tamanhosJson;
?>