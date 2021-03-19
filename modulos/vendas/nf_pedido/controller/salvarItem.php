<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $infos = json_decode($json, true);

    foreach ($infos as $dados) {
        $sql = "SELECT quantidade_saldo FROM item_pedido WHERE pedido = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nf]) AND produto = $dados[produto]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if($query){
            $linha = mysqli_fetch_array($query);
            $qtdSaldo = $linha[0];
            if($dados['qtdFaturar'] <= $qtdSaldo){
                $qtdSaldoAtual = $qtdSaldo - $dados['qtdFaturar'];
                $sql = "INSERT INTO item_nf(nota_fiscal, produto, quantidade_faturar, valor_unitario, valor_total) VALUES ((SELECT id FROM nota_fiscal WHERE numero = $dados[nf]), $dados[produto], $dados[qtdFaturar], $dados[valUnit], $dados[valTotal])";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                if($query){
                    $sql = "UPDATE item_pedido SET quantidade_saldo = $qtdSaldoAtual WHERE pedido = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nf]) AND produto = $dados[produto]";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                    if($query){
                        movimentarEstoque($link, $dados);
                        atualizaStatusPedido($link, $dados);
                    }else{
                        echo "Erro ao atualizar saldo do produto no pedido. \n". mysqli_error($link);
                    }
                }else{
                    echo "Erro ao adicionar item ao faturamento. \n" . mysqli_error($link);
                }
            }else{
                echo "Quantidade a faturar maior que saldo do pedido.";
            }
        }else{
            echo "Erro ao obter saldo do produto. \n" . mysqli_error($link);
        };
    }



function movimentarEstoque($link, $dados){
    $sqlOrigemEstoque = "SELECT tp_venda.origem_movto_estoque
                         FROM tp_venda INNER JOIN pedidos
                         WHERE tp_venda.id = pedidos.tp_venda AND pedidos.id  = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nf])";
    $sqlTPMovto = "SELECT tp_venda.tp_movto_estoque
                  FROM tp_venda INNER JOIN pedidos
                  WHERE tp_venda.id = pedidos.tp_venda AND pedidos.id  = (SELECT pedido FROM nota_fiscal WHERE numero = $dados[nf])";
    $sqlDataMovto = date("Y-m-d");
    $sql = "INSERT INTO movimento_estoque(produto, origem_estoque, tp_movto_estoque, quantidade, valor, num_doc, data) VALUES($dados[produto], ($sqlOrigemEstoque),($sqlTPMovto), $dados[qtdFaturar], $dados[valTotal], $dados[nf],'$sqlDataMovto')";
    $query = mysqli_query($link, $sql);
    if($query){
        
    }else{
        echo "Erro ao movimentar estoque do produto. \n".mysqli_error($link);
    }
}   

function atualizaStatusPedido($link, $dados){
    $sql = "SELECT pedido FROM nota_fiscal WHERE numero = $dados[nf]";
    $query = mysqli_query($link, $sql);
    $linha = mysqli_fetch_array($query);
    $pedido = $linha[0];

    $sql = "UPDATE pedidos SET status = 3 WHERE id = $pedido";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
}
echo 1;