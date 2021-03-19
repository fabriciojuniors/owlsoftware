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
    $sql = "SELECT produto.descricao, origem_estoque.descricao as origem, tp_movto_estoque.descricao as tp_movto, quantidade, valor, num_doc, data
    FROM movimento_estoque INNER JOIN produto
                           INNER JOIN origem_estoque
                           INNER JOIN tp_movto_estoque
    WHERE produto.id = movimento_estoque.produto AND origem_estoque.id = movimento_estoque.origem_estoque AND tp_movto_estoque.id = movimento_estoque.tp_movto_estoque AND movimento_estoque.data BETWEEN '$dados[dtinicial]' AND '$dados[dtfinal]' AND produto.id = '$cod' AND
    tp_movto_estoque LIKE '%$tpmovto%'
    ORDER BY movimento_estoque.data DESC";
    //echo $sql;
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    
    while(@$row = mysqli_fetch_array($query)){
        //@$result[] = $row;
        @$result[] = [
            'num_doc' => $row['num_doc'],
            'origem' => $row['origem'],
            'data' => $row['data'],
            'quantidade' => number_format((float)$row['quantidade'],2,",","."),
            'valor' => number_format((float)$row['valor'],2,",","."),
            'tp_movto' => $row['tp_movto']
        ];
    }
    echo @json_encode($result);

?>