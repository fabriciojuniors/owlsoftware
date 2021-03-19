<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT DISTINCT produto.descricao, item_nf.quantidade_faturar, produto.id,
            if ((SELECT produto FROM item_nf WHERE nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero = $dados[nota]) AND produto = produto.id), 1, 0) as adicionado
                FROM item_nf INNER JOIN produto
                WHERE produto.id = item_nf.produto AND item_nf.nota_fiscal = (SELECT id FROM nota_fiscal WHERE numero =$dados[notaDevolvida])";
                //echo $sql;
    @$query = mysqli_query($link, $sql);

    if(@mysqli_num_rows($query)>0){
        while(@$row = mysqli_fetch_array($query)){
            $item[] = $row;
        }
        $itemJ = json_encode($item);
        echo $itemJ;
    }else{echo "Não foi possível carregar os itens da nota fiscal. \n" . mysqli_error($link);}