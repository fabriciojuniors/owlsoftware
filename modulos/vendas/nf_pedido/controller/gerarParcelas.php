<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $valorNF = valorNF($link, $dados);
    $condPag = condPag($link, $dados);
    $condPag = explode("/", $condPag);
    $qtdParcelas = count($condPag);
    $valorParcelas = round(($valorNF / $qtdParcelas),2);

    $diferenca = $valorNF - ($valorParcelas*$qtdParcelas);
    //echo $diferenca;
    foreach ($condPag as $condicao) {
        $vencimentos[] = date("Y-m-d", strtotime("+ $condicao days"));    
    }
    foreach ($vencimentos as $vencimento){
        $parcelas[]= array(
            'valor' => $valorParcelas,
            'vencimento' => $vencimento
        );
    }
    $parcelas[$qtdParcelas-1]['valor'] = $parcelas[$qtdParcelas-1]['valor'] + $diferenca;
    $parcelasJ = json_encode($parcelas);
    echo $parcelasJ;

    
    function valorNF($link, $dados){
        $sql = "SELECT SUM(valor_total) FROM item_nf WHERE nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero = $dados[nota])";
        $query = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($query);
        $valor = $result[0];
        return $valor;
    }

    function condPag($link, $dados){
        $sql = "SELECT condicao FROM condicao_pagamento WHERE id = $dados[condicao_pagamento]";
        $query = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($query);
        $valor = $result[0];
        return $valor;
    }