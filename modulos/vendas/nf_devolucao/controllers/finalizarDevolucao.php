<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    //Recupera a nota;
    $sql = "SELECT * FROM nota_fiscal WHERE numero = $dados[nota]";
    $query = mysqli_query($link,$sql);
    $nota = mysqli_fetch_array($query);

    //Recupera TP Venda
    $sql = "SELECT * FROM tp_venda WHERE id = $nota[tp_venda]";
    $query = mysqli_query($link,$sql);
    $tpVenda = mysqli_fetch_array($query);

    //Recupera os itens
    $sql = "SELECT * FROM item_nf WHERE nota_fiscal = $nota[id]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $erro = "";
    if(mysqli_num_rows($query)){
        while($row = mysqli_fetch_array($query)){
            $sql = "INSERT INTO movimento_estoque(produto, origem_estoque, tp_movto_estoque, quantidade, valor, num_doc, data) VALUES(
                $row[produto], $tpVenda[origem_movto_estoque], $tpVenda[tp_movto_estoque],$row[quantidade_faturar], $row[valor_unitario], $nota[numero], '$nota[emissao]')";
            $queryItem = mysqli_query($link, $sql) or die(mysqli_error($link));
            if(!$query){
                $erro .= "Erro ao adicionar item. \n" . mysqli_error($link);
            }
        }
        if($erro == ''){
            $sql = "UPDATE nota_fiscal SET status = 3 WHERE id = $nota[nota_referenciada]";
            $query = mysqli_query($link,$sql) or die(mysqli_error($link));
            $sql = "UPDATE nota_fiscal SET status = 2 WHERE id = $nota[id]";
            $query = mysqli_query($link,$sql) or die(mysqli_error($link));
            if(!$query){
                $erro .= "Erro ao atualizar status da NF Referenciada. \n" . mysqli_error($link);
                echo $erro;
            }
        }else{
            echo $erro;
        }
    }else{
        echo "Não é possível finalizar a devolução sem itens adicionados.";
    }