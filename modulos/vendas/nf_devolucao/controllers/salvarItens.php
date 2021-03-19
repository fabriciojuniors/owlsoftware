<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $erro = '';
    foreach ($dados as $produto) {
        $sql = "SELECT valor_unitario FROM item_nf WHERE nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero = $produto[nfDev]) AND produto = $produto[produto]";
        $query = mysqli_query($link, $sql);
        $valor = mysqli_fetch_array($query);
        $valor = $valor[0];
        $sql = "INSERT INTO item_nf(nota_fiscal, produto, quantidade_faturar, valor_unitario) VALUES((SELECT id FROM nota_fiscal WHERE numero=$produto[nota]), $produto[produto], $produto[qtd], $valor)";
        $query = mysqli_query($link, $sql);
        if(!$query){
            $erro .= "Erro ao adicionar produto".$produto['produto']." na nota fiscal.". mysqli_error($link);
        }
    }
    echo $erro;