<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    //Recupera a nota;
    $sql = "SELECT * FROM nota_fiscal WHERE numero = $dados[nota]";
    $query = mysqli_query($link,$sql);
    $nota = mysqli_fetch_array($query);

    $sql = "SELECT item_nf.id, produto.id as produto, produto.descricao, quantidade_faturar as devolvida, (SELECT quantidade_faturar FROM item_nf WHERE nota_fiscal = $nota[nota_referenciada] AND produto = produto.id) as faturada
    FROM item_nf INNER JOIN produto
    WHERE item_nf.produto = produto.id AND item_nf.nota_fiscal = $nota[id]";
    $query = mysqli_query($link,$sql);
    $itens;
    if(mysqli_num_rows($query)>0){
        while($row = mysqli_fetch_array($query)){
            $itens[] = [
                'id' => $row['id'],
                'produto' => $row['produto']." - ".$row['descricao'],
                'devolvida' => number_format((float)$row['devolvida'],2,",","."),
                'faturada' => number_format((float)$row['faturada'],2,",","."),
            ];
        }
        $itensJ = json_encode($itens);
        echo $itensJ;
    }else{echo "nao";}
