<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT item_nf_entrada.id, item_nf_entrada.nota, produto.cod as produto, item_nf_entrada.codXML, item_nf_entrada.quantidade, item_nf_entrada.valor FROM item_nf_entrada INNER JOIN produto WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $dados[nota]) AND produto.id = item_nf_entrada.produto";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    $result = [];
    if($query){
        if(mysqli_num_rows($query)>0){
            while($row = mysqli_fetch_array($query)){
                $result[]= $row;
            }
            $resultJ = json_encode($result);
            echo $resultJ;
        }else{echo 0;}
    }