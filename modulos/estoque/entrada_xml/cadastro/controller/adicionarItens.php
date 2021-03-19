<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $erro = '';
    foreach ($dados as $info) {
        $sql = "DELETE FROM item_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $info[nota]) AND produto = (SELECT id FROM produto WHERE cod = '$info[produto]')";
        $query = mysqli_query($link, $sql);
        if(!$query){
            $erro = "Não foi possível remover os itens da nota fiscal. \n". mysqli_error($link);
        }
    }

    if($erro != ''){
        echo $erro;
        return;
    }

    foreach ($dados as $info) {
        $qtd = str_replace(".","", $info['qtd']);
        $qtd2 = str_replace(",",".", $qtd);
        $valor = str_replace(".","", $info['valor']);
        $valor2 = str_replace(",",".", $valor);
        $sql = "INSERT INTO item_nf_entrada(nota, produto, quantidade, valor, codXML) VALUES(
           (SELECT id FROM nota_fiscal_entrada WHERE numero = $info[nota]), (SELECT id FROM produto WHERE cod = '$info[produto]'),  $qtd2, $valor2, '$info[codXML]'
        )";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    }
    
    echo "Salvo com sucesso.";
    