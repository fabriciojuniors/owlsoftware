<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $filtro = $dados['filtro'];

    $filtro = ($filtro == 1) ? $where = "ordem_recebimento.numero" : $where = "clientes.id";

    $sql = "SELECT liquidacao_or.id, ordem_recebimento.numero, parcela_or.numero, clientes.nome, liquidacao_or.data, liquidacao_or.valor_movimentacao, tp_movto_financeiro.descricao
            FROM liquidacao_or INNER JOIN parcela_or
                            INNER JOIN ordem_recebimento
                            INNER JOIN clientes
                            INNER JOIN tp_movto_financeiro
            WHERE liquidacao_or.parcela_or = parcela_or.id AND ordem_recebimento.id = parcela_or.ordem_recebimento AND clientes.id = ordem_recebimento.cliente AND 
                liquidacao_or.tp_movto_financeiro = tp_movto_financeiro.id AND $where LIKE '%$dados[buscar]%'
            ORDER BY liquidacao_or.data ASC";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
  
    if(mysqli_affected_rows($link)>0){
        while($row = mysqli_fetch_array($query)){
            $result[] = $row; 
        }
    
        $resultJ = json_encode($result);
        echo $resultJ;
    }else{
        echo 0;
    }
