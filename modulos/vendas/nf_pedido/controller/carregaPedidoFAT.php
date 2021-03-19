<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $sql = "SELECT pedidos.numero, pedidos.cliente, pedidos.tp_venda, nota_fiscal.emissao, nota_fiscal.entrega, nota_fiscal.forma_pagamento, nota_fiscal.condicao_pagamento
    FROM pedidos INNER JOIN nota_fiscal
    WHERE pedidos.id = nota_fiscal.pedido AND pedidos.numero = $dados[pedido]";
    
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query)>0){
       $pedido = mysqli_fetch_array($query) ;
       $pedidoJ = json_encode($pedido);
       echo $pedidoJ;
    }else{
        echo 0;
    }