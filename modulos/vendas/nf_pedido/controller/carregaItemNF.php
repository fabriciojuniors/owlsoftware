<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT produto.descricao, item_nf.* FROM item_nf INNER JOIN produto WHERE item_nf.produto = produto.id AND nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero = $dados[nf])";
    $query = mysqli_query($link, $sql);

    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $itens[] = $row;
        }
        $itensJ = json_encode($itens);
        echo $itensJ;
    }else{ echo 1; }
