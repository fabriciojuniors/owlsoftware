<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT * FROM item_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(!$query){
        echo "Erro ao obter itens da nota fiscal. \n" . mysqli_error($link);
        return;
    }

    while($itens = mysqli_fetch_array($query)){
        $sql = "INSERT INTO movimento_estoque(produto, origem_estoque, tp_movto_estoque, quantidade, valor, num_doc, data)
                VALUES($itens[produto], (SELECT origem_estoque FROM tp_entrada WHERE id = (SELECT tp_entrada FROM nota_fiscal_entrada WHERE numero = $dados[nota])), 1, $itens[quantidade], $itens[valor], '$dados[nota]', (SELECT entrada FROM nota_fiscal_entrada WHERE numero=$dados[nota]))";
        $queryM = mysqli_query($link, $sql);
        if(!$queryM){
            echo "Erro ao salvar movimentação de estoque. \n" . mysqli_error($link);
            return;
        }
    }

    $sql = "SELECT * FROM nota_fiscal_entrada WHERE numero = $dados[nota]";
    $query = mysqli_query($link, $sql);
    $nota = mysqli_fetch_array($query);

    $sql = "SELECT MAX(numero+1) FROM ordem_pagamento";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $numero = $row[0];
    $sql = "INSERT INTO ordem_pagamento(numero, cliente, emissao, valor_total, valor_saldo, condicao, forma_pagamento, status,tipo)
            VALUES($numero, $nota[fornecedor], '$nota[emissao]', (SELECT SUM(valor) FROM item_nf_entrada WHERE nota=(SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])), (SELECT SUM(valor) FROM item_nf_entrada WHERE nota=(SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])), $nota[condicao_pagamento], $nota[forma_pagamento], 1, 'OP')";
    $query = mysqli_query($link, $sql);
    if(!$query){
        echo "Erro ao salvar financeiro. \n" . mysqli_error($link);
        return;
    }

    $sql = "INSERT INTO comentario_op(comentario, ordem_pagamento, usuario) VALUES ('Ordem de pagamento gerada através da nota fiscal n° $dados[nota]' , (SELECT id FROM ordem_pagamento WHERE numero = $numero), '$_SESSION[usuario]' )";
    $query = mysqli_query($link, $sql);

    $sql = "SELECT * FROM parcela_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    $i = 1;
    while($row = mysqli_fetch_array($query)){
        $sql = "INSERT INTO parcela_op(ordem_pagamento, numero, emissao, vencimento, valor, valor_saldo, status)
                VALUES((SELECT id FROM ordem_pagamento WHERE numero = $numero), $i, '$nota[emissao]', '$row[vencimento]', $row[valor],$row[valor],1)";
        $queryP = mysqli_query($link, $sql);
        if(!$queryP){
            echo "Erro ao salvo parcela financeira. \n" . mysqli_error($link);
            return;
        }
        $i++;
    }

    $sql = "UPDATE nota_fiscal_entrada SET status = 2 WHERE numero = $dados[nota]";
    $query = mysqli_query($link, $sql);

    if($query){
        echo 1;
    }else{
        echo "Erro ao finalizar nota fiscal. \n" . mysqli_error($link);
    }

    