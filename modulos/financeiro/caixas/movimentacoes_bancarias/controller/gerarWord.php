<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    require $_SERVER['DOCUMENT_ROOT']."/owlsoftware/vendor/autoload.php";

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $conta = $_GET['conta'];
    $iemissao = $_GET['iemissao'];
    $femissao = $_GET['femissao'];
$pagina ='';
$pagina .='<title>Movimentação Bancária</title>';
$pagina .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';
$pagina .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';
$pagina .= '<body style="margin-left: 3%; margin-right: 3%">';
$pagina .='<h3 style="text-align: center">Relatório de movimentação bancária</h3>';
$pagina .='<p>Filtros</p>';
$pagina .='<p><strong>Inicio emissão:</strong>'.$iemissao.'</p>';
$pagina .='<p><strong>Fim emissão:</strong>'.$femissao.'</p>';
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
         $pagina .="<table class='table table-sm' id='tabelaResultado'>";
            $pagina.="<thead>";
            $pagina.='<th>Origem Docto</th>';
            $pagina.='<th>N° Docto</th>';
            $pagina.='<th>Cliente/Fornecedor</th>';
            $pagina.='<th>Data</th>';
            $pagina.='<th>Movimentação</th>';
            $pagina.='<th>Observação</th>';
            $pagina.='<th>Valor</th>';
            $pagina.='<th>Saldo Bancário</th>';
            $pagina.='</thead>';
            $pagina.='<tbody>';
        while($row = mysqli_fetch_array($query)){
            $resultado[] = $row;
        }
        $i =0;
        foreach ($resultado as $row) {
            $pagina.="<tr>";
            $pagina.="<td>".$row[0]."</td>";
            $pagina.="<td>".$row[2]."/".$row[3]."</td>";
            $pagina.="<td>".$row[1]."</td>";
            $pagina.="<td>".$row[4]."</td>";
            $pagina.="<td>".$row[6]."</td>";
            $pagina.="<td>".$row[7]."</td>";
            $pagina.="<td>R$".$row[5]."</td>";
            $pagina.="<td id='saldo'>R$";
                        
                        if($i == 0){
                        if($row[0] == "OR"){
                            $pagina.=$row[5];
                        }else{
                            $pagina.= $row[5];
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
                           $pagina.= number_format($saldo,2,',','.');
                           
                       }else{
                        $pagina.= number_format($saldo,2,',','.');
                           //colSaldo.innerHTML = "R$"+saldo.toFixed(2).split(".").join(",");
                       }
                       
                   }
                   $pagina.= "</td>";
                $pagina.="</tr>";
        $i++;}}
                          
$pagina.="</tbody>";
$pagina.="</table>";

$section->addText($pagina);

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('movimentacaoBancaria.docx');

echo $pagina;