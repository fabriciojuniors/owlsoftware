<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $nota = $_GET['numero'];
    $sqlProduto = "SELECT produto.descricao, produto, quantidade_faturar, valor_total
            FROM item_nf INNER JOIN nota_fiscal INNER JOIN produto
            WHERE item_nf.nota_fiscal = nota_fiscal.id AND item_nf.produto = produto.id AND nota_fiscal.id = (SELECT id FROM nota_fiscal WHERE numero = $nota)";
    $queryProduto = mysqli_query($link, $sqlProduto);

    $sqlParcelas = "SELECT * FROM parcela_nf WHERE nota = (SELECT id FROM nota_fiscal WHERE numero = $nota)";
    $queryParcelas = mysqli_query($link, $sqlParcelas);
?>
<link rel="stylesheet" href="/owlsoftware/common/css/style.css">
<script src="/owlsoftware/modulos/vendas/nf_pedido/js/finalizar.js"></script>
<div class="row">
    <div class="col-sm" style="border-right: 1px solid darkgray; max-height: 350px; overflow-y: auto;">
        <label for="">Itens do faturamento</label>
        <table class="table table-sm table-hover">
            <thead>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </thead>
            <tbody>
                <?php
                    while($row = mysqli_fetch_array($queryProduto)){
                ?>
                    <tr>
                        <td><?php echo $row['produto']; ?></td>
                        <td><?php echo str_replace(".", ",", $row['quantidade_faturar']); ?></td>
                        <td><?php echo "R$". str_replace(".", ",", $row['valor_total']); ?></td>
                    </tr>        
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm" style="max-height: 350px; overflow-y: auto;">
        <label for="">Financeiro - Parcelas</label>

        <table class="table table-sm table-hover">
            <thead>
                <th>Nº</th>
                <th>Valor</th>
                <th>Vencimento</th>
            </thead>
            <tbody>
                <?php
                    while($rowP = mysqli_fetch_array($queryParcelas)){
                ?>
                    <tr>
                        <td><?php echo $rowP['numero']; ?></td>
                        <td><?php echo "R$".str_replace(".", ",", $rowP['valor']);?></td>
                    <td><?php echo date("d/m/Y", strtotime($rowP['vencimento'])); ?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr style="width: 75%">
<button type="button" onclick="finalizarNF()" style="float: right; margin-left: 5%"  class="btn btn-square btn-success">Finalizar</button>