<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT pedidos.numero, nota_fiscal.* FROM nota_fiscal INNER JOIN pedidos WHERE nota_fiscal.pedido = pedidos.id AND nota_fiscal.numero = $dados[nota]";
    $query = mysqli_query($link, $sql);

    $linha = mysqli_fetch_array($query);
    $nota = json_encode($linha);
    echo $nota;