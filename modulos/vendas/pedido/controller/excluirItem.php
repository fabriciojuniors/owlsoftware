<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "DELETE FROM item_pedido WHERE id  = $dados[id]";
    $query = mysqli_query($link, $sql);
    if($query){
        echo "Excluído com sucesso";
    }else{
        echo "Erro ao excluir item. ". mysqli_error($link);
    }