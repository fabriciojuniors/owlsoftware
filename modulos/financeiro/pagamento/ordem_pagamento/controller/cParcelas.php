<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT *, status_op.descricao FROM parcela_op inner join status_op WHERE parcela_op.status = status_op.id AND ordem_pagamento = $dados[id] ORDER BY vencimento DESC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($linha = mysqli_fetch_array($query)){
        $parcelas[] = $linha;
    }
    $parcelaJson = json_encode($parcelas);
    echo $parcelaJson;
?>