<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
<script src="/owlsoftware/modulos/vendas/pedido/js/funcoes.js"></script>
<script src="/owlsoftware/modulos/vendas/pedido/js/adicionarItem.js"></script>
<script>

</script>
<div class="row" style="margin-top: 1%">
    <div class="col">
    <button type="button" onclick="limparItem()" class="btn btn-square btn-light" style="margin-left: 1%; border: 1px solid rgb(110, 107, 107);float: right">Novo</button>
      <button class="btn btn-success btn-square" onclick="adicionarItem()" style="float: right">Adicionar</button>
      
        <label for="">Produto</label> <input type="hidden" id="idItemPedido">
        <div class="input-group mb-3" style="width: 400px;">
            <div class="input-group-prepend" id="button-addon3">
            <input type="text" class="form-control campos" onchange="buscarProduto(this.value)" style="width: 80px;" id="codProd">
            <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalProduto" style="width: 40px;" type="button" id="selecaoProd">...</button>
            </div>
            <input type="text" disabled class="form-control campos" id="descprod"  style="width: 10px;"  placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
        </div>
        <div class="row">
          <div class="col-md-auto" style="margin-right: 5%">
            <div class="form-group">
              <label for="">Quantidade</label>
              <input type="text" onchange="calcularValorTotal(this.value)" onkeyup="mascara(this)" id="quantidade" class="form-control campos">
            </div>
            <div class="form-group">
              <label for="">% Desconto (Unitário)</label>
              <input type="text" class="form-control campos" onchange="aplicaDesconto(this.value)"  onkeyup="mascara(this)"  id="desconto">
            </div>
          </div>
          <div class="col-md-auto">
              <div class="form-group">
                <label for="">Preço (Unitário)</label>
                <input type="text" onchange="calcularValorTotal()" class="form-control campos"  onkeyup="mascara(this)" id="precoUnitario">
            </div>
            <div class="form-group">
                <label for="">Preço (Total)</label>
                <input type="text" class="form-control campos"  onkeyup="mascara(this)" id="precoTotal">
            </div>
          </div>
        </div>
    </div>

</div>
<div class="row" style="margin-top: 2%;">
<div class="col">
<table class="table table-sm table-stripped">
    <thead>
      <th>Produto</th>
      <th>Quantidade</th>
      <th>Preço unitário</th>
      <th>Desconto unitário</th>
      <th>Preço total</th>
      <th>Editar</th>
      <th>Excluir</th>
    </thead>
    <tbody id="itensPedido" ></tbody>
  </table>
</div>
</div>
  <!-- Modal Seleção do produto -->
  <div class="modal" id="modalProduto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Produto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="selecaoProd">
            <form action="" id="selecaoProd">
              <div class="container">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">Descrição</label>
                      <input type="text" class="form-control" id="s_descricao">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">Grupo</label>
                      <select name="" id="g_prod" class="form-control">
                        <option value="#">Selecione</option>
                        <?php
                            $sql = "SELECT * FROM grupo_produto WHERE inativo = 0";
                            $query = mysqli_query($link, $sql);
                            if(mysqli_num_rows($query)>0){
                                while($row = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['descricao']  ?></option>
                                    <?php
                                };
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">Tipo</label>
                      <select name="" id="t_prod" class="form-control">
                        <option value="#">Selecione</option>
                        <?php
                            $sql = "SELECT * FROM tipo_produto WHERE inativo = 0";
                            $query = mysqli_query($link, $sql);
                            if(mysqli_num_rows($query)>0){
                                while($row = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['descricao']  ?></option>
                                    <?php
                                };
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <input type="button" onclick="selecaoProd()" value="Pesquisar" class="btn btn-primary btn-square">
              </div>   
            </form>
            <div id="resultado" style="margin-top: 5%; max-height:300px; overflow-y:auto;">
              <table class="table" id="resultado_produtos" style="align-content:center;">
                
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>