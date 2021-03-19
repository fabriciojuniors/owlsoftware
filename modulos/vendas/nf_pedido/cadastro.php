<div class="row" style="margin-top: 1%">
          <div class="col">
            <div class="form-group">
                <label for="">N° Pedido</label>
                <input type="text" onchange="carregaPedido(this.value)" class="form-control campos" style="width: 85px" id="numPedido">
            </div>   
            <div class="form-group">
                <label for="">Tipo de venda</label>
                <select name="tpVenda" id="tpVenda" disabled class="form-control campos">
                    <option value="#">Selecione</option>
                    <?php
                        $sql = "SELECT * FROM tp_venda WHERE inativo = 0";
                        $query = mysqli_query($link, $sql);
                        if(mysqli_num_rows($query)>0){
                            while($row = mysqli_fetch_array($query)){
                                ?>
                                  <option value="<?php echo $row['id'] ?>"><?php echo $row['descricao'] ?></option>  
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <label for="">Cliente</label>
            <div class="input-group mb-3" style="width: 400px;">
                <div class="input-group-prepend" id="button-addon3">
                <input type="text" class="form-control campos" onchange="buscarClie(this.value)" readonly style="width: 80px;" id="codCli">
                <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" style="width: 40px; pointer-events: none" type="button" id="selecaoCli">...</button>
                </div>
                <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;"  placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label for="">N° NF</label>
              <input type="text" style="width: 80px" class="form-control campos" readonly id="numNF">
            </div>
            <div class="form-group">
                <label for="">Emissão</label>
                <input type="date" name="" readonly value="<?php echo date("Y-m-d"); ?>" id="emissao" class="form-control campos">
            </div>
            <div class="form-group">
                <label for="">Entrega</label>
                <input type="date" name="" value="<?php echo date("Y-m-d"); ?>" id="entrega" class="form-control campos">
            </div>
            <label for="">Usuário cadastro: <?php echo $_SESSION['usuario'] ?></label> <br>
            <label for="">Usuário atualização: <?php echo $_SESSION['usuario'] ?></label>
          </div>
      </div>

      <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCliente">Seleção de Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label for="">CPF/CNPJ</label>
            <input type="text" class="form-control campos" id="cpfcnpj">
          </div>
          <div class="col">
            <label for="">Nome</label>
            <input type="text" class="form-control campos" id="nome">
          </div>
        </div>
        <button style="margin-top: 10px;" class="btn btn-primary btn-square" id="pesquisarCli" onclick="pesquisarCli()">Pesquisar</button>

        <div id="divResultado" style="max-height: 400px; overflow-y: auto; margin-top: 15px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>