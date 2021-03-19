<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT quantidade_faturar, produto, nota_fiscal.pedido FROM item_nf INNER JOIN nota_fiscal WHERE nota_fiscal.id = item_nf.nota_fiscal AND item_nf.id = $dados[item]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $linha = mysqli_fetch_array($query);
    $qtdFaturar = $linha[0];

    $sql = "DELETE FROM item_nf WHERE id = $dados[item]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    if($query){
        $sql = "UPDATE item_pedido set quantidade_saldo = (quantidade_saldo+$qtdFaturar) where produto = $linha[1] AND pedido = $linha[2]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if($query){
            excluirMovto($link, $dados, $linha);
            atualizaStatusPedido($link, $dados);
        }else{
            echo "Erro ao atualizar saldo do produto. \n".mysqli_error($link);
        }
    }else{
        echo "Erro ao excluir produto. \n".mysqli_error($link);
    }

function excluirMovto($link, $dados, $linha){
    $sqlOrigemEstoque = "SELECT tp_venda.origem_movto_estoque
    FROM tp_venda INNER JOIN pedidos
    WHERE tp_venda.id = pedidos.tp_venda AND pedidos.id  = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nota])";
    $sqlTPMovto = "SELECT tp_venda.tp_movto_estoque
    FROM tp_venda INNER JOIN pedidos
    WHERE tp_venda.id = pedidos.tp_venda AND pedidos.id  = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nota])";
    $sql = "DELETE FROM movimento_estoque WHERE num_doc = $dados[nota] AND produto = $linha[1] AND origem_estoque = ($sqlOrigemEstoque) AND tp_movto_estoque = ($sqlTPMovto)";
    //echo $sql;
    $query = mysqli_query($link, $sql);
    if($query){
        echo "Excluído com sucesso.";
    }else{
        echo "Erro ao excluir movimentação de estoque. \n".mysqli_error($link);
    }
}

function atualizaStatusPedido($link, $dados){
    $sql = "SELECT * FROM item_nf WHERE nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero  = $dados[nota])";
    $query = mysqli_query($link, $sql);
    if(mysqli_num_rows($query) > 0){
        $sql = "UPDATE pedidos SET status = 4 WHERE id =(SELECT pedido FROM nota_fiscal WHERE numero  = $dados[nota]) ";
    }else{
        $sql = "UPDATE pedidos SET status = 2 WHERE id =(SELECT pedido FROM nota_fiscal WHERE numero  = $dados[nota]) ";
    }
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
}