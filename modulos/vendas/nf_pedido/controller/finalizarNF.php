<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/modulos/vendas/nf_pedido/enviarNF/enviar.php";
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $erro = "Nota finalizada com sucesso.";
    $sql = "UPDATE nota_fiscal SET status = 2 WHERE numero = $dados[nota]";
    $query = mysqli_query($link, $sql);

    $sql = "SELECT gera_financeiro FROM tp_venda WHERE id = (SELECT tp_venda FROM nota_fiscal WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_row($query);
    $geraFinanceiro = $row[0];
    if($geraFinanceiro == 1){
        gerarFinanceroNF($dados, $link);
    }
    function gerarFinanceroNF($dados, $link){
        $sqlParcelas = "SELECT * FROM parcela_nf WHERE nota = (SELECT id FROM nota_fiscal WHERE numero = $dados[nota])";
        $queryParcelas = mysqli_query($link, $sqlParcelas);
        $valor_total = 0;
        while($parcelas = mysqli_fetch_array($queryParcelas)){
            $valor_total += (float)$parcelas['valor'];
        }
    
        $sqlNota = "select nota_fiscal.*, pedidos.cliente 
                    from nota_fiscal INNER JOIN pedidos
                    WHERE nota_fiscal.pedido = pedidos.id AND nota_fiscal.numero = $dados[nota]";
        $queryNota = mysqli_query($link, $sqlNota);
        $nota = mysqli_fetch_array($queryNota);
        $emissao = $nota['emissao'];
        $sqlNumeroOR = "SELECT ifnull((MAX(numero)+1),1)  FROM ordem_recebimento";
        $queryNumeroOR = mysqli_query($link, $sqlNumeroOR);
        $numeroOR = mysqli_fetch_array($queryNumeroOR);
        $numeroOR = $numeroOR[0];
    
        $sqlInsereOR = "INSERT INTO ordem_recebimento(numero, cliente, valor_total, valor_saldo, condicao, forma_pagamento, status, emissao) VALUES
                        ($numeroOR, $nota[cliente], $valor_total, $valor_total, $nota[condicao_pagamento], $nota[forma_pagamento], 1, '$emissao')";
        $queryInsereOR = mysqli_query($link, $sqlInsereOR) or die(mysqli_error($link));
        if(!$queryInsereOR){
            $sql = "UPDATE nota_fiscal SET status = 1 WHERE numero = $dados[nota]";
            $query = mysqli_query($link, $sql);
            $erro = "Erro ao gerar ordem de recebimento. \n".mysqli_error($link);
    
        }
        
        $sqlComentario = "INSERT INTO comentario_or(comentario, usuario, ordem_recebimento) VALUES
                         ('Ordem de recebimento gerado através da nota fiscal nº $nota[numero]. (Comentário automático.)', '$_SESSION[usuario]', (SELECT id FROM ordem_recebimento WHERE numero = $numeroOR) )";
        $queryComentario = mysqli_query($link, $sqlComentario) or die(mysqli_error($link));
    
        $sqlNumero = "SELECT IFNULL((MAX(numero)+1),1)  AS numero FROM parcela_or WHERE ordem_recebimento = (SELECT id FROM ordem_recebimento WHERE numero = $numeroOR)";
        $queryNumero = mysqli_query($link, $sqlNumero);
        $numero = mysqli_fetch_array($queryNumero);
        $numero = $numero[0];
    
        $sqlParcelas2 = "SELECT * FROM parcela_nf WHERE nota = (SELECT id FROM nota_fiscal WHERE numero = $dados[nota])";
        $queryParcelas2 = mysqli_query($link, $sqlParcelas2);
        while($parcela = mysqli_fetch_array($queryParcelas2)){
            
            $sqlParcela = "INSERT INTO parcela_or(ordem_recebimento, numero, emissao, vencimento, valor, valor_saldo, status) VALUES
                           ((SELECT id FROM ordem_recebimento WHERE numero = $numeroOR), $numero, '$emissao', '$parcela[vencimento]', $parcela[valor], $parcela[valor],1)";
            $queryParcela = mysqli_query($link, $sqlParcela) or die(mysqli_error($link));
            if(!$queryParcela){
                $sql = "UPDATE nota_fiscal SET status = 1 WHERE numero = $dados[nota]";
                $query = mysqli_query($link, $sql);
                $erro = "Erro ao gerar parcela da ordem de recebimento. \n".mysqli_error($link);
            }
            $numero++;
            
        }
        
    }
    $sqlNota = "select nota_fiscal.*, pedidos.cliente 
    from nota_fiscal INNER JOIN pedidos
    WHERE nota_fiscal.pedido = pedidos.id AND nota_fiscal.numero = $dados[nota]";
    $queryNota = mysqli_query($link, $sqlNota);
    $nota = mysqli_fetch_array($queryNota);
    infoEmail($nota,$link,$dados);
    function infoEmail($nota,$link,$dados){
        $sql = "SELECT email FROM clientes WHERE id = $nota[11]";
        $query = mysqli_query($link, $sql);
        $linha = mysqli_fetch_array($query);
        $info = [
            'email' => $linha[0],
            'msg' => 'Você está recebendo este e-mail refente a nota fiscal n°'.$dados['nota'],
            'nota' =>$dados['nota']
        ];
        enviarEmail($info);
    }

    echo $erro;