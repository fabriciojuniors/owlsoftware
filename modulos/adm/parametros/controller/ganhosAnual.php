<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $dataInicio = date("Y-01-01");
    $dataFim = date("Y-12-31");

    $sql = "SELECT SUM(valor_movimentacao) as total FROM liquidacao_or WHERE data BETWEEN '$dataInicio' and '$dataFim'";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    if(mysqli_num_rows($query)>0){
        $row = mysqli_fetch_array($query);
        $rowJ = json_encode($row);
        echo $rowJ;
    }else{
        echo 'nao';
    }