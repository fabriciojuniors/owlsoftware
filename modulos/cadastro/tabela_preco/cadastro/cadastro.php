<div class="row">
    <div class="col">
        <label for="">Código</label>
        <input type="text" readonly value="<?php echo isset($row['codigo']) ?  $row['codigo'] : '' ?>" style="width: 80px" class="form-control campos" id="codigo">
        <label for="">Descrição</label>
        <input type="text" class="form-control campos" value="<?php echo isset($row['descricao']) ?  $row['descricao'] : '' ?>" id="descricao">
        <label for="">% Max. Desconto</label>
        <input type="text" id="max_desconto" value="<?php echo isset($row['max_desconto']) ?  $row['max_desconto'] : '' ?>" style="width: 120px;" class="form-control campos">
    </div>
    <div class="col">
        <label for="">Criação</label>
        <input type="date" name="" value="<?php echo isset($row['max_desconto']) ?  $row['criacao'] : date("Y-m-d") ?>" readonly id="criacao" class="form-control campos">
        <label for="">Atualização</label>
        <input type="date" name="" value='<?php echo date("Y-m-d")?>' readonly id="atualizacao"
            class="form-control campos">
        <label for="">Usuário criação: <?php echo isset($row['nome']) ? $row['nome'] : $_SESSION['usuario'];?></label> <br>
        <label for="">Usuário atualização: <?php echo $_SESSION['usuario'];?></label>
    </div>
</div>