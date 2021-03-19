<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $filtro = $dados['filtro'];

    $filtro = ($filtro == 1) ? $where = "ordem_recebimento.numero" : $where = "clientes.id";
    $sql = "SELECT parcela_or.id ,parcela_or.ordem_recebimento, parcela_or.numero, LEFT(clientes.nome, 50), parcela_or.vencimento, parcela_or.valor, parcela_or.valor_saldo, ordem_recebimento.numero
            FROM parcela_or INNER JOIN ordem_recebimento INNER JOIN clientes
            WHERE parcela_or.ordem_recebimento = ordem_recebimento.id AND ordem_recebimento.cliente = clientes.id AND parcela_or.valor_saldo > 0 AND $where LIKE '%$dados[buscar]%'
            ORDER BY parcela_or.vencimento DESC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_array($query)){
            $parcelas[] = $row;
        }
        $parcelaJ = json_encode($parcelas);
        echo $parcelaJ;
    }else{
        echo 0;
    }


