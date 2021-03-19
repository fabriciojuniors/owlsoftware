<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $conta = $_GET['conta'];
    $iemissao = $_GET['iemissao'];
    $femissao = $_GET['femissao'];
    ($iemissao == '')? $iemissao = '2000-01-01': $iemissao = $iemissao;
    ($femissao == '')? $femissao = date("Y-m-d"): $femissao = $femissao;
?>
<title>Movimentação Bancária</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/owlsoftware/menu/vendor/fontawesome-free/css/all.css">
<body style="margin-left: 3%; margin-right: 3%">
<h3 style="text-align: center">Relatório de movimentação bancária</h3>
<p>Filtros</p>
<p><strong>Inicio emissão:</strong><?php echo $iemissao ?></p>
<p><strong>Fim emissão:</strong><?php echo $femissao ?></p>
<?php
    $sql = "SELECT ordem_recebimento.tipo, clientes.nome, ordem_recebimento.numero as titulo, parcela_or.numero as parcela, liquidacao_or.data, liquidacao_or.valor_movimentacao, tp_movto_financeiro.descricao, ordem_recebimento.observacao
    FROM liquidacao_or INNER JOIN clientes
                       INNER JOIN ordem_recebimento
                       INNER JOIN parcela_or
                       INNER JOIN tp_movto_financeiro
    WHERE liquidacao_or.parcela_or = parcela_or.id AND parcela_or.ordem_recebimento = ordem_recebimento.id AND clientes.id = ordem_recebimento.cliente AND tp_movto_financeiro.id = liquidacao_or.tp_movto_financeiro AND tp_movto_financeiro.liquidacao = 1 AND conta_bancaria = $conta AND data BETWEEN '$iemissao' AND '$femissao'
    UNION
    SELECT ordem_pagamento.tipo, clientes.nome, ordem_pagamento.numero as titulo, parcela_op.numero as parcela, liquidacao_op.data, liquidacao_op.valor_movimentacao, tp_movto_financeiro.descricao, ordem_pagamento.observacao
    FROM liquidacao_op INNER JOIN clientes
                       INNER JOIN ordem_pagamento
                       INNER JOIN parcela_op
                       INNER JOIN tp_movto_financeiro
    WHERE liquidacao_op.parcela_op = parcela_op.id AND parcela_op.ordem_pagamento = ordem_pagamento.id AND clientes.id = ordem_pagamento.cliente AND tp_movto_financeiro.id = liquidacao_op.tp_movto_financeiro AND tp_movto_financeiro.liquidacao = 1 AND conta_bancaria = $conta AND data BETWEEN '$iemissao' AND '$femissao'
    ORDER BY data ASC";
    //echo $sql;
    $query = mysqli_query($link, $sql);

    if(mysqli_num_rows($query)>0){
        ?>
        <table class='table table-sm' id='tabelaResultado'margin-bottom: 5%">
            <thead>
                <th style="text-align: center">Origem Docto</th>
                <th style="text-align: center">N° Docto</th>
                <th>Cliente/Fornecedor</th>
                <th style="text-align: center">Data</th>
                <th style="text-align: center">Movimentação</th>
                <th>Observação</th>
                <th style="text-align: center">Valor</th>
                <th style="text-align: center">Saldo Bancário</th>
            </thead>
            <tbody>
        <?php
        while($row = mysqli_fetch_array($query)){
            $resultado[] = $row;
        }
        $i =0;
        foreach ($resultado as $row) {
        ?>
        <tr >
                    <td align="center"><?php echo $row[0] ?></td>
                    <td align="center"><?php echo $row[2]?> / <?php echo $row[3]?></td>
                    <td ><?php echo $row[1] ?></td>
                    <td align="center"><?php echo implode("/", array_reverse(explode("-", $row[4])))  ?></td>
                    <td align="center"><?php echo $row[6] ?></td>
                    <td><?php echo $row[7] ?></td>
                    <td align="center">R$<?php echo number_format((float)$row[5],2,",","."); ?></td>
                    <td id="saldo" align="center">
                        R$    
                        <?php
                        if($i == 0){
                        if($row[0] == "OR"){
                            echo $row[5];
                        }else{
                            echo $row[5];
                        }
                    }else{
                        $soma =0;
                        $menos =0;
                        $saldo = 0;
                        $mAnt = $resultado[$i-1];
                       for($j=0; $j<=$i; $j++){
                            $mAntes = $resultado[$j];
                           if($mAntes[0] == "OR"){
                               $soma += $mAntes[5];
                           }else{
                               $menos += $mAntes[5];
                           }
                       }
                       $saldo = $soma-$menos;
                       if($saldo < 0){
                           echo number_format($saldo,2,',','.');
                           
                       }else{
                           echo number_format($saldo,2,',','.');
                           //colSaldo.innerHTML = "R$"+saldo.toFixed(2).split(".").join(",");
                       }
                       
                   }
                   ?>
                    </td>
                </tr>
        <?php   
        $i++;}}
        ?>
                
          
</tbody>
</table>
<div class="row" style="position: fixed; bottom: 5; margin-top: 2%">
    <div class="col-sm-auto"><a href="gerarExcel.php?conta=<?php echo $conta ?>&iemissao=<?php echo $iemissao?>&femissao=<?php echo $femissao ?>"><i style="font-size: 32px; color:green; float: right; position: absolute; bottom: 5" class="fas fa-file-excel"></i></i></a></div>
    <div class="col-sm-auto"><a href="gerarWord.php?conta=<?php echo $conta ?>&iemissao=<?php echo $iemissao?>&femissao=<?php echo $femissao ?>"><i style="font-size: 32px; color:blue; float: right; position: absolute; bottom: 5" class="fas fa-file-word"></i></a></div>


</div>

</body>
        