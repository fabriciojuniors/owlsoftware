<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM grupo_produto WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $grupos[] = $row;
        
    };
    $gruposJson = json_encode($grupos);
    echo $gruposJson;
?>