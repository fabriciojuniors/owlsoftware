<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
    $sql = "SELECT COUNT(id), id FROM tp_venda WHERE inativo = 0";
    $query = mysqli_query($link, $sql);
    $linha = mysqli_fetch_array($query);
    $qtd = $linha[0];
    $idInicial = $linha[1];
    $iemissao = $_POST['iemissao'];
    $femissao = $_POST['femissao'];
    $ientrega = $_POST['ientrega'];
    $fentrega = $_POST['fentrega'];
    $ordenacao = $_POST['ordenacao'];

    if(isset($_POST['codCli'])){
        $cliente = $_POST['codCli'];
    }else{
        $cliente = '';
    }
    $tpVenda = [];
    $continua = true;
    
    while($qtd >= 0){
        $p = 'tpVenda'.$qtd;
        if(isset($_POST[$p])){
            $tpVenda[] = $_POST[$p];
        }
        $qtd--;
    }
    $tps = implode(",", $tpVenda);
    $somaTotal = 0;
?>
    <div id="cabecalho">
       <p style="margin-bottom: 3% ;text-align: center;"> <strong>Rel. Notas Fiscais Emitidas por Período "Elegante"</strong> </p> 
       <p><strong>Emissão: </strong> <?php echo date("d/m/Y", strtotime($iemissao) ); ?> à <?php echo date("d/m/Y", strtotime($femissao) ); ?>
        <br> <strong>Entrega: </strong> <?php echo date("d/m/Y", strtotime($ientrega) ); ?> à <?php echo date("d/m/Y", strtotime($fentrega) ); ?>
        <br> <strong>Tipos de Venda: </strong> <?php echo $tps ?>
        <br> <strong>Cliente: </strong> <?php echo $cliente ?>
        <br> <strong>Ordenação:</strong> <?php if($ordenacao == 'nota_fiscal.numero') echo "Nota fiscal"; if($ordenacao == 'pedidos.numero') echo "Pedido de Venda"; if($ordenacao == 'clientes.id') echo "Cliente"; if($ordenacao == 'nota_fiscal.emissao') echo "Emissão";if($ordenacao == 'nota_fiscal.entrega') echo "Entrega";?>
        </p>
    </div>
<?php

    foreach ($tpVenda as $t ) {
        $somaValor = 0;
        $sqlRel = "SELECT nota_fiscal.numero as nota, pedidos.numero as pedido, clientes.nome as cliente, nota_fiscal.emissao, nota_fiscal.entrega, (SELECT SUM(valor_total) from item_nf WHERE item_nf.nota_fiscal = nota_fiscal.id) as valor, tp_venda.descricao as tpVenda, nota_fiscal.tp_venda as tpVendaID
        FROM nota_fiscal INNER JOIN pedidos INNER JOIN clientes INNER JOIN tp_venda
        WHERE nota_fiscal.pedido = pedidos.id AND pedidos.cliente = clientes.id AND nota_fiscal.tp_venda = tp_venda.id AND clientes.id LIKE '%$cliente%' AND nota_fiscal.emissao BETWEEN '$iemissao' AND '$femissao' AND nota_fiscal.tp_venda = $t order by $ordenacao DESC";
        $queryRel = mysqli_query($link, $sqlRel) or die (mysqli_error($link));
        if(mysqli_num_rows($queryRel)>0){

        for($i = 0 ; $i < mysqli_num_rows($queryRel) ; $i++){
            $nota = mysqli_fetch_array($queryRel);
            $somaValor += floatval($nota['valor']); 
            if($i == 0){
                ?>
                    <div style="border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 1%;"><strong><?php echo $nota['tpVendaID'] . " - ". $nota['tpVenda']; ?></strong></div>
                    <div >
                    <table style="width: 100%; text-align: justify;">
                    <thead>
                        <th style="width: 3%;">N° Nota</th>
                        <th style="width: 3%;">N° Pedido</th>
                        <th style="width: 15%;">Cliente</th>
                        <th style="width: 6%;">Emissão</th>
                        <th style="width: 5%;">Entrega</th>
                        <th style="width: 5%;">Valor</th>
                    </thead>
                    <tbody>
                <?php
            }
            ?> 
                <tr>
                    <td><?php echo $nota['nota']?></td>
                    <td><?php echo $nota['pedido'];?></td>
                    <td><?php echo $nota['cliente'];?></td>
                    <td><?php echo date("d/m/Y", strtotime($nota['emissao']));?></td>
                    <td><?php echo ($nota['entrega'] == null) ?  "Não definida" :  date("d/m/Y", strtotime($nota['entrega']));?></td>
                    <td><?php echo "R$ " . number_format($nota['valor'],2, ',','.');?></td>
                </tr> 
                <?php
                    if($i == (mysqli_num_rows($queryRel)-1)){
                ?>        
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td> <?php echo "R$ " . number_format($somaValor,2, ',','.');$somaTotal += $somaValor; ?></td>
                    </tr>
                <?php }
                    }
                ?>
                    </tbody>
                </table>
                </div>

            <?php
            }else{
                echo "oi";
            }
            }; ?>
            <div style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <?php
                if(@$somaTotal == 0){
                    ?>
                        <strong>Nenhum registro localizado, revise os filtros informados.</strong>
                    <?php
                }else{
                    ?>
                        <strong>Valor total:</strong> <?php echo "R$ " . number_format($somaTotal,2, ',','.'); ?>
                    <?php
                }
            ?>
            </div>
