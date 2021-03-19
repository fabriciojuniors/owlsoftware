<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $cod = $dados['cod'];

    $sql = "SELECT * FROM produto WHERE cod = '$cod' AND inativo = '0'";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) > 0){
        $prod[] = mysqli_fetch_array($query);
        $prodJson = json_encode($prod);
        echo $prodJson;
    }else{
        echo "Produto não localizado";
    }
?>