<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['idItemPedido'] == ''){
        $sql = "SELECT * from item_pedido where pedido =(SELECT id FROM pedidos WHERE numero = $dados[numPedido]) AND produto = (SELECT id FROM produto WHERE cod = '$dados[codProd]')";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if(mysqli_num_rows($query)<=0){
            $sql = "INSERT INTO item_pedido(pedido, produto, quantidade,quantidade_saldo, preco_unitario, preco_total, desconto) VALUES((SELECT id FROM pedidos WHERE numero = $dados[numPedido]), (SELECT id FROM produto WHERE cod = '$dados[codProd]'), $dados[quantidade], $dados[quantidade], $dados[precoUnitario], $dados[precoTotal], $dados[desconto])";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            if($query){
                echo "1";
            }else{
                echo "Erro ao adicionar produto. " . mysqli_error($link);
            }
        }else{
            echo "Item já adicionado no pedido.";
        }

    }else{
        $sql = "UPDATE item_pedido SET quantidade = $dados[quantidade], quantidade_saldo = $dados[quantidade],  preco_unitario = $dados[precoUnitario], preco_total = $dados[precoTotal], desconto = $dados[desconto] WHERE id = $dados[idItemPedido]";
        $query = mysqli_query($link, $sql);
        if($query){
            echo "1";
        }else{
            echo "Erro ao atualizar produto". mysqli_error($link);
        }
    }
