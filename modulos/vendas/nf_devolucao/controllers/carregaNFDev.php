<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    
    $sql = "SELECT (SELECT numero FROM nota_fiscal where id = (SELECT nota_referenciada FROM nota_fiscal WHERE numero = $dados[nota])) as devolvida, tp_venda FROM nota_fiscal WHERE numero = $dados[nota]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) >0){
        $nota = mysqli_fetch_array($query);
        $notaJ = json_encode($nota);
        echo $notaJ;
    }else{echo "0";};