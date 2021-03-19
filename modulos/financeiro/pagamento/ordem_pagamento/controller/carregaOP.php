<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT ordem_pagamento.numero, parcela_op.numero, ordem_pagamento.cliente, ordem_pagamento.emissao, parcela_op.vencimento, ordem_pagamento.valor_total, parcela_op.valor, ordem_pagamento.condicao, ordem_pagamento.forma_pagamento, ordem_pagamento.condicao, ordem_pagamento.observacao, parcela_op.status
            FROM parcela_op inner join ordem_pagamento
            WHERE parcela_op.ordem_pagamento = ordem_pagamento.id AND parcela_op.ordem_pagamento = $dados[id] AND parcela_op.numero = 1";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $resultado = mysqli_fetch_array($query);
    $resultadoJson = json_encode($resultado);
    echo $resultadoJson;
?>
