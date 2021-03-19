<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $sql = "SELECT * FROM item_nf WHERE nota_fiscal = (SELECT id FROM nota_fiscal where numero = $dados[nota])";
    $query = mysqli_query($link, $sql);
    if(mysqli_num_rows($query)>0){
        $sql = "SELECT DISTINCT CASE WHEN (item_nf.produto = item_pedido.produto) THEN '1' else '0' end as existe, produto.descricao, item_pedido.*, (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  = item_pedido.produto),0)) as entrada,
        (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = item_pedido.produto),0)) as saida, 
        ( 
            (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  = item_pedido.produto),0)) - 
            (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = item_pedido.produto),0) )
        ) as saldo
        FROM item_pedido INNER JOIN produto LEFT JOIN item_nf on (item_nf.produto = produto.id)
        WHERE item_pedido.produto = produto.id AND pedido = (SELECT id FROM pedidos where numero = $dados[pedido])";
    }else{
        $sql = "SELECT DISTINCT produto.descricao, item_pedido.*, (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  = item_pedido.produto),0)) as entrada,
        (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = item_pedido.produto),0)) as saida, 
        ( 
            (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 1 AND produto  = item_pedido.produto),0)) - 
            (IFNULL ((SELECT SUM(quantidade) FROM movimento_estoque WHERE tp_movto_estoque = 2 AND produto  = item_pedido.produto),0) )
        ) as saldo
        FROM item_pedido INNER JOIN produto
        WHERE item_pedido.produto = produto.id AND pedido = (SELECT id FROM pedidos where numero = $dados[pedido])"; 
    }
    //echo $sql;
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    while($row = mysqli_fetch_array($query)){
        $itens[] = $row;
    }
    $itensJ = json_encode($itens);
    echo $itensJ;