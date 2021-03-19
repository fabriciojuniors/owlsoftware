<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    
    $cod = $_POST['cod'];

    $sql = "SELECT * FROM tipo_produto WHERE cod='$cod'";
    $query = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($query);

    if($resultado['cod'] != ''){
        echo 1;
    } else{
        echo 0;
    }


    
?>