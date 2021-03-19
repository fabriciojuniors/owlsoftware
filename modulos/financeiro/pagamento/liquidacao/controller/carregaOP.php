<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $filtro = $dados['filtro'];

    $filtro = ($filtro == 1) ? $where = "ordem_pagamento.numero" : $where = "clientes.id";
    $sql = "SELECT parcela_op.id ,parcela_op.ordem_pagamento, parcela_op.numero, LEFT(clientes.nome, 50), parcela_op.vencimento, parcela_op.valor, parcela_op.valor_saldo, ordem_pagamento.numero
            FROM parcela_op INNER JOIN ordem_pagamento INNER JOIN clientes
            WHERE parcela_op.ordem_pagamento = ordem_pagamento.id AND ordem_pagamento.cliente = clientes.id AND parcela_op.valor_saldo > 0 AND $where LIKE '%$dados[buscar]%'
            ORDER BY parcela_op.vencimento DESC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_array($query)){
            $parcelas[] = $row;
        }
        $parcelaJ = json_encode($parcelas);
        echo $parcelaJ;
    }else{
        echo 0;
    }


