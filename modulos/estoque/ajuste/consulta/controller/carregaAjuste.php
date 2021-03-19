<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    
    if(@$dados['cod'] == null){
        $dados['cod'] = '';
    }
    if(@$dados['inicio'] == null){
        $dados['inicio'] = '2000-01-01';
    }
    if(@$dados['fim'] == null){
        $dados['fim'] = date('Y-m-d');
    }
    $sql = "SELECT ajuste.id, ajuste.data, ajuste.observacao, origem_estoque.descricao from ajuste INNER JOIN origem_estoque WHERE origem_estoque = origem_estoque.id AND ajuste.id like '%$dados[cod]%' AND ajuste.data BETWEEN '$dados[inicio]' AND '$dados[fim]'";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
    while($row = mysqli_fetch_array($query)){
        @$result[] = $row;
    }
    echo @json_encode($result);

?>