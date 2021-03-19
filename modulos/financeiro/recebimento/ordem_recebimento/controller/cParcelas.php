<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sql = "SELECT *, status_or.descricao FROM parcela_or inner join status_or WHERE parcela_or.status = status_or.id AND ordem_recebimento = $dados[id] ORDER BY vencimento DESC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    while($linha = mysqli_fetch_array($query)){
        $parcelas[] = $linha;
    }
    $parcelaJson = json_encode($parcelas);
    echo $parcelaJson;
?>