<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $sql = "SELECT (SELECT SUM(ordem_recebimento.valor_total) FROM ordem_recebimento), SUM(ordem_recebimento.valor_total) as soma, clientes.nome as cliente FROM ordem_recebimento INNER JOIN clientes WHERE ordem_recebimento.cliente = clientes.id GROUP BY cliente ORDER BY soma DESC LIMIT 5";
    $query = mysqli_query($link, $sql);

    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $resultado[] = $row;   
        }
        $resultadoj = $resultado;
        echo json_encode($resultadoj);
    }else{
        echo 1;
    }