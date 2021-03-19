<script src="/owlsoftware/modulos/vendas/pedido/js/finalizarPedido.js"></script>
<button class="btn btn-success btn-square" onclick="salvarParcelas()" style=" margin-right: 1%; float: right">Confirmar</button>
<div class="row" style="margin-top: 1%">
    <div class="col">
        <div class="form-group">
            <label for="">Forma de pagamento</label>
            <select name="" id="sFormaPagto" class="form-control campos">
                <option value="#">Selecione</option>
                <?php
                    $sql = "SELECT * FROM forma_pagamento WHERE inativo = 0";
                    $query = mysqli_query($link, $sql);
                    if(mysqli_num_rows($query)>0){
                        while($row = mysqli_fetch_array($query)){
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['descricao']; ?> </option>
                            <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="">Condição de pagamento</label>
            <select name="" onchange="gerarParcelas()" id="sCondPagto" class="form-control campos">
                <option value="#">Selecione</option>
                <?php
                    $sql = "SELECT * FROM condicao_pagamento WHERE inativo = 0";
                    $query = mysqli_query($link, $sql);
                    if(mysqli_num_rows($query)>0){
                        while($row = mysqli_fetch_array($query)){
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['descricao']; ?> </option>
                            <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
</div>

<div style="margin-top: 2%; margin-left: 2%" class="row">
    <p> <strong>Parcelas</strong></p> <br>
</div>    
<div  style="margin-left: 2%; width: 40%; height: 300px; overflow-x: hidden;">
 <div class="row">
     <div class="col">
         <label for="">Vencimento</label>
     </div>
     <div class="col">
         <label for="">Valor</label>
     </div>
 </div>
 <div id="parcelas"></div>
</div>
