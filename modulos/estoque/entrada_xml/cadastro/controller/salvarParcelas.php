<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $erro = '';
    $sql = "DELETE FROM parcela_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql);

    $sql = "SELECT SUM(valor) FROM item_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota])";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $valor = $row[0];

    $sql = "SELECT * FROM condicao_pagamento WHERE id = $dados[condicao]";
    $query = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($query);
    $data = $row['condicao'];
    $data = explode("/", $data);
    
    $qtdParcela = count($data);
    
    $valorParcela = $valor / $qtdParcela;
    $valorParcela = round($valorParcela, 2);
    
    foreach ($data as $condicao) {
        $vencimentos[] = date("Y-m-d", strtotime("+ $condicao days"));    
    }
    for ($i=0; $i < count($vencimentos); $i++) { 
        $vencto = $vencimentos[$i];
        $sql = "INSERT INTO parcela_nf_entrada(nota, numero, valor, vencimento) VALUES((SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota]), $i, $valorParcela, '$vencto')";
        $query = mysqli_query($link, $sql);
        if(!$query){$erro = 'Não foi possível salvar parcelas da NF. \n' . mysqli_error($link); echo $erro; return;}
    }

    $sql = "UPDATE nota_fiscal_entrada SET forma_pagamento = $dados[forma], condicao_pagamento = $dados[condicao] WHERE numero = $dados[nota]";
    $query = mysqli_query($link, $sql);

    if(!$query){$erro = 'Não foi possível atualizar a NF. \n' . mysqli_error($link); echo $erro; return;}

    $erro = "Salvo com sucesso";
    echo $erro;