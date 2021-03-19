<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM pedidos WHERE numero  = $dados[pedido]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $pedido = mysqli_fetch_array($query);
    $pedidoJ = json_encode($pedido);
    echo $pedidoJ;