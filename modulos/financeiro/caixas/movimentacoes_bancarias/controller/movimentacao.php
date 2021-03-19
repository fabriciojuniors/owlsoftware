<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    ($dados['iemissao'] == '')? $inicio = "2000-01-01" : $inicio = $dados['iemissao'];
    ($dados['femissao'] == '')? $fim = date("Y-m-d") : $fim = $dados['femissao'];
    //echo $inicio, $fim;
    $sql = "SELECT ordem_recebimento.tipo, clientes.nome, ordem_recebimento.numero as titulo, parcela_or.numero as parcela, liquidacao_or.data, liquidacao_or.valor_movimentacao, tp_movto_financeiro.descricao, ordem_recebimento.observacao
    FROM liquidacao_or INNER JOIN clientes
                       INNER JOIN ordem_recebimento
                       INNER JOIN parcela_or
                       INNER JOIN tp_movto_financeiro
    WHERE liquidacao_or.parcela_or = parcela_or.id AND parcela_or.ordem_recebimento = ordem_recebimento.id AND clientes.id = ordem_recebimento.cliente AND tp_movto_financeiro.id = liquidacao_or.tp_movto_financeiro AND tp_movto_financeiro.liquidacao = 1 AND conta_bancaria = $dados[conta] AND data BETWEEN '$inicio' AND '$fim'
    UNION
    SELECT ordem_pagamento.tipo, clientes.nome, ordem_pagamento.numero as titulo, parcela_op.numero as parcela, liquidacao_op.data, liquidacao_op.valor_movimentacao, tp_movto_financeiro.descricao, ordem_pagamento.observacao
    FROM liquidacao_op INNER JOIN clientes
                       INNER JOIN ordem_pagamento
                       INNER JOIN parcela_op
                       INNER JOIN tp_movto_financeiro
    WHERE liquidacao_op.parcela_op = parcela_op.id AND parcela_op.ordem_pagamento = ordem_pagamento.id AND clientes.id = ordem_pagamento.cliente AND tp_movto_financeiro.id = liquidacao_op.tp_movto_financeiro AND tp_movto_financeiro.liquidacao = 1 AND conta_bancaria = $dados[conta] AND data BETWEEN '$inicio' AND '$fim'
    ORDER BY data ASC";
    //echo $sql;
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $result[] = $row;
        }
        $resultJ = json_encode($result);
        echo $resultJ;
    }else{
        echo 0;
    }