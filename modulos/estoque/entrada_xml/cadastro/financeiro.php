<?php

$sql = "SELECT SUM(valor) FROM item_nf_entrada WHERE nota = (SELECT id FROM nota_fiscal_entrada WHERE numero = $_GET[n])";
$query = mysqli_query($link, $sql);
$row = mysqli_fetch_array($query);
$valor = $row[0];

if(isset($_GET['n'])){
    $sql = "SELECT * FROM nota_fiscal_entrada WHERE numero = $_GET[n]";
    $query = mysqli_query($link, $sql);
    $nota = mysqli_fetch_array($query);
}
?>
<div id="formCond" style="margin-top: 1%;">
    <p>Valor total fianceiro: <strong>R$<?php echo number_format($valor, 2, ",", "."); ?></strong> </p>

    <div class="row">
        <div class="col-md-2">
            <label for="">Forma de Pagamento</label>
            <select class="form-control" style="width: 200px;" name="formaPag" id="formaPag">
                <option value="#">Selecione</option>
                <?php
                $sql = "SELECT * FROM forma_pagamento WHERE inativo = 0";
                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <option <?php echo ($nota['forma_pagamento'] == $row['id']) ? "selected" : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['descricao']; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Condição de Pagamento</label>
            <select onchange="gerarParcelas()" class="form-control" style="width: 200px;" name="condPag" id="condPag">
                <option value="#">Selecione</option>
                <?php
                $sql = "SELECT * FROM condicao_pagamento WHERE inativo = 0";
                $query = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <option <?php echo ($nota['condicao_pagamento'] == $row['id']) ? "selected" : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['descricao']; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>
<script>gerarParcelas()</script>
<hr style="width: 80%; align-items: center;">
<div id="parcelas" style="margin-top: 2%;">
    <table class="table table-sm table-hover">
        <thead>
            <th>N°</th>
            <th>Vencimento</th>
            <th>Valor</th>
        </thead>
        <tbody id="tbParcelas">

        </tbody>
    </table>
</div>
<div id="finalizar" style="float: right;">
    <button class="btn btn-success btn-square" <?php echo ($valor > 0) ? '' : "disabled title='Para gerar as parcelas é preciso adicionar os itens primeiramente.'";?> onclick="salvarParcelas()">Confirmar</button>
    <button id="btn-finalizar" onclick="finalizarEntrada()" title="Bloqueado. É necessário gerar as parcelas da NF antes de finalizá-la." class="disabled btn btn-success btn-square">Finalizar</button>
</div>