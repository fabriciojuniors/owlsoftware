<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);


    $sql = "SELECT * FROM item_ajuste WHERE id = $dados[produto]";
    $query = mysqli_query($link, $sql);
    $movimentacao = mysqli_fetch_array($query);
    $sql = "DELETE FROM item_ajuste WHERE id = $dados[produto]";
    $query = mysqli_query($link, $sql);
    if($query){
        $sql = "DELETE FROM movimento_estoque WHERE produto = $movimentacao[produto] AND quantidade = $movimentacao[quantidade] AND tp_movto_estoque = $movimentacao[tp_movto_estoque]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));;
        
        if($query){
            echo "Excluido";
        }else{
            echo "Erro ao excluir movimentação. \n" . mysqli_error($link);
        }
    }else{
        echo "Erro ao excluir item do ajuste. " . mysqli_error($link);
    }
?>    