<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  =$dados[produto]),0)) as entrada,
    (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = $dados[produto]),0)) as saida, 
    ( 
        (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  = $dados[produto]),0)) - 
        (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = $dados[produto]),0) )
    ) as saldo";
    $query = mysqli_query($link, $sql);
    $linha = mysqli_fetch_array($query);
    $resultado = json_encode($linha);
    echo $resultado;