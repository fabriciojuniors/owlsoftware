<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "select item_ajuste.id, produto.cod, produto.descricao, item_ajuste.quantidade, item_ajuste.custo, tamanho.descricao from item_ajuste inner join produto inner join tamanho where produto.id = item_ajuste.produto and tamanho.id = item_ajuste.tamanho and item_ajuste.id_ajuste = $dados[ajuste]";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($row = mysqli_fetch_array($query)){
        $result[] = $row;
    }
    $resultJson = json_encode($result);
    echo $resultJson;
?>