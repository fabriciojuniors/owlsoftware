<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    @$sqlProd = "SELECT id FROM produto WHERE cod = '$dados[produto]'";
    @$queryProd = mysqli_query($link, $sqlProd);
    @$cod = mysqli_fetch_array($queryProd)[0];
    if($dados['tpmovto'] == '#'){
        $tpmovto = '';
    }else{
        $tpmovto = $dados['tpmovto'];
    }
    if($dados['tamanho'] == '#'){
        $tamanho = '';
    }else{
        $tamanho = $dados['tamanho'];
    }
    $sql = "SELECT SUM(quantidade)
    FROM item_ajuste INNER JOIN ajuste 
                    INNER JOIN origem_estoque
                    INNER JOIN tamanho
                    INNER JOIN produto
    WHERE ajuste.id = item_ajuste.id_ajuste AND origem_estoque.id = ajuste.origem_estoque AND tamanho.id = tamanho AND produto.id = produto AND 
        ajuste.data BETWEEN '$dados[dtinicial]' AND '$dados[dtfinal]' AND
        produto.id = '$cod' AND
        tp_movto_estoque = 1 AND
        tamanho LIKE '%$tamanho%'";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while(@$row = mysqli_fetch_array($query)){
    @$result[] = $row;
    }
    //echo $sql;
    echo @json_encode($result);