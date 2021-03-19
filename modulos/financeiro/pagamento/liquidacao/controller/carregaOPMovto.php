<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $filtro = $dados['filtro'];

    $filtro = ($filtro == 1) ? $where = "ordem_pagamento.numero" : $where = "clientes.id";

    $sql = "SELECT liquidacao_op.id, ordem_pagamento.numero, parcela_op.numero, clientes.nome, liquidacao_op.data, liquidacao_op.valor_movimentacao, tp_movto_financeiro.descricao
            FROM liquidacao_op INNER JOIN parcela_op
                            INNER JOIN ordem_pagamento
                            INNER JOIN clientes
                            INNER JOIN tp_movto_financeiro
            WHERE liquidacao_op.parcela_op = parcela_op.id AND ordem_pagamento.id = parcela_op.ordem_pagamento AND clientes.id = ordem_pagamento.cliente AND 
                liquidacao_op.tp_movto_financeiro = tp_movto_financeiro.id AND $where LIKE '%$dados[buscar]%'
            ORDER BY liquidacao_op.data ASC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
  
    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_array($query)){
            $result[] = $row; 
        }
    
        $resultJ = json_encode($result);
        echo $resultJ;
    }else{
        echo 0;
    }
