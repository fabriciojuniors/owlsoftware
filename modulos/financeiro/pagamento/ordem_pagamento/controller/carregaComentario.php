<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT data, comentario, usuario FROM comentario_op WHERE ordem_pagamento = (SELECT id FROM ordem_pagamento WHERE numero = $dados[nop]) ORDER BY data DESC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $result[] = $row;
        }
        $resultJ = json_encode($result);
        echo $resultJ;
    }else{
        echo 0;
    }