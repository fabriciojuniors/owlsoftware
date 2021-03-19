<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $sql = "SELECT produto.descricao, item_pedido.* FROM item_pedido INNER JOIN produto WHERE item_pedido.produto = produto.id AND pedido = (SELECT id FROM pedidos WHERE numero = $dados[pedido])";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $itens[] = $row;
        }
        $itensJ = json_encode($itens);
        echo $itensJ;
    }