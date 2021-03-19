<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "DELETE FROM item_nf WHERE id = $dados[item]";
    $query = mysqli_query($link,$sql) or die (mysqli_error($link));

    if($query){
        echo '';
    }else{
        echo "Erro ao excluir movimentação. \n" . mysqli_error($link);
    }