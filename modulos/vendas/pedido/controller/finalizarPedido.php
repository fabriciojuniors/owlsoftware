<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "UPDATE pedidos SET forma_pagamento = $dados[formaPag], condicao_pagamento = $dados[condPag], observacoes = '$dados[obs]', status = 2 WHERE numero = $dados[pedido]";
    $query = mysqli_query($link, $sql);
    if($query){
        echo "Pedido finalizado com sucesso.";
    }else{
        echo "Erro ao finalizar pedido de venda. ". mysqli_error($link);
    }