<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT SUM(valor) FROM item_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $valor = $row[0];

    $sql = "SELECT * FROM condicao_pagamento WHERE id = $dados[condicao]";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $data = $row['condicao'];
    $data = explode("/", $data);
    
    $qtdParcela = count($data);
    
    $valorParcela = $valor / $qtdParcela;
    $valorParcela = round($valorParcela, 2);
    
    foreach ($data as $condicao) {
        $vencimentos[] = date("Y-m-d", strtotime("+ $condicao days"));    
    }
    foreach ($vencimentos as $vencimento){
        $parcelas[]= array(
            'valor' => number_format($valorParcela,1,",","."),
            'vencimento' => date("d/m/Y",strtotime($vencimento))
        );
    }

    $parcelasJ = json_encode($parcelas);
    echo $parcelasJ;