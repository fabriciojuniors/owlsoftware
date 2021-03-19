<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    if($dados['nota'] != ''){
        $sql = "SELECT * FROM pedidos WHERE numero = $dados[pedido]";
    }else{
        $sql ="SELECT *, (SELECT SUM(quantidade_saldo) FROM item_pedido WHERE pedido = (SELECT id FROM pedidos WHERE numero = $dados[pedido])) as saldo FROM pedidos WHERE numero = $dados[pedido]";
    }
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query)>0){
       $pedido = mysqli_fetch_array($query) ;
       $pedidoJ = json_encode($pedido);
       echo $pedidoJ;
    }else{
        echo 0;
    }