<div class="row" style="margin-top: 10px;">
    <div class="col">
        <div class="form-group">
            <label for="">Nota devolvida</label>
            <input type="text" style="width: 90px;" onchange="buscaNFDev(this.value)" class="form-control campos" id="nfDev">
        </div>
        <div class="form-group">
            <label for="">Tipo de devolução</label>
            <select class="form-control campos" name="tp_devolucao" id="tp_devolucao">
                <option value="#">Selecione</option>
                <?php
                    $sql = "SELECT * FROM tp_venda WHERE inativo = 0 AND devolucao = 1";
                    $query = mysqli_query($link, $sql);
                    if(mysqli_num_rows($query) > 0){
                        
                        while($row = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['descricao']; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="">N° NF</label>
            <input type="text" id="numNF" class="form-control campos" readonly style="width: 90px;">
        </div>
        <div class="form-group">
            <label for="">Emissão</label>
            <input type="date" value="<?php echo date('Y-m-d'); ?>" id="emissao" class="form-control campos"> 
            <label for="">Usuário: <?php echo $_SESSION['usuario']; ?></label>
        </div>
    </div>
</div>