<script src="/owlsoftware/modulos/vendas/pedido/js/finalizarPedido.js"></script>
<button class="btn btn-square" style=" margin-right: 1%; border: 1px solid rgb(110, 107, 107);float: right">Imprimir</button>
<button class="btn btn-success btn-square" onclick="finalizarPedido()" style=" margin-right: 1%; float: right">Finalizar</button>
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
            <select name="" id="sCondPagto" class="form-control campos">
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
<div class="row" style="margin-left: 0.1%">
    <div class="col">
        <label for="">Observações</label>
        <textarea name="obs" id="obs" cols="30" style="width: 50%; height: 50%" class="form-control" rows="10"></textarea>
    </div>
    <div class="col"></div>
</div>