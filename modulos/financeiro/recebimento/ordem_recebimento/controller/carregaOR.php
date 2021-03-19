<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT ordem_recebimento.numero, parcela_or.numero, ordem_recebimento.cliente, ordem_recebimento.emissao, parcela_or.vencimento, ordem_recebimento.valor_total, parcela_or.valor, ordem_recebimento.condicao, ordem_recebimento.forma_pagamento, ordem_recebimento.condicao, ordem_recebimento.observacao, parcela_or.status
            FROM parcela_or inner join ordem_recebimento
            WHERE parcela_or.ordem_recebimento = ordem_recebimento.id AND parcela_or.ordem_recebimento = $dados[id] AND parcela_or.numero = 1";
    $query = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($query);
    $resultadoJson = json_encode($resultado);
    echo $resultadoJson;
?>
