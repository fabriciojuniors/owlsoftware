<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $parcela = $dados[0];
    $nota = $parcela['nota'];
    $sql = "DELETE FROM parcela_nf WHERE nota = (SELECT id FROM nota_fiscal WHERE numero = $nota)";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $sql = "UPDATE nota_fiscal SET forma_pagamento = $parcela[forma_pagamento], condicao_pagamento = $parcela[condicao_pagamento] WHERE numero = $nota";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $erro = 'false';

    foreach ($dados as $parcelas) {
        $idNota = "SELECT id FROM nota_fiscal WHERE numero = $nota";
        $sql = "SELECT ifnull((SELECT max(numero) FROM parcela_nf where nota = ($idNota))+1, 1)";
        $query = mysqli_query($link, $sql);
        $linha = mysqli_fetch_array($query);
        $numero = $linha[0];
        
        $sql = "INSERT INTO parcela_nf(numero, nota, valor, vencimento) VALUES($numero , (SELECT id FROM nota_fiscal WHERE numero = $nota) , $parcelas[valor], '$parcelas[vencimento]')";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if(!$query){
            $erro = "Erro ao salvar parcela da NF. \n" . mysqli_error($link);
        }
    }
    echo $erro;