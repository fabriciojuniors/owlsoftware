<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "select max(CAST(cod as int)) from tipo_produto";
    $query = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($query);
    
    echo $resultado[0]; 
?>