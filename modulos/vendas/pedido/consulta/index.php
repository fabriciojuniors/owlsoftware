<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="/owlsoftware/modulos/vendas/pedido/consulta/js/funcoes.js"></script>
  <!-- <script src="/owlsoftware/modulos/vendas/pedido/js/funcoes.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
  <title>Consulta - Pedido de Venda</title>
</head>
<style>
input[type="date"]::-webkit-inner-spin-button{
    display: none;
    -webkit-appearance: none;
}
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Consulta - Pedido de Venda</h1>
    
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisarPedido(1,8, document.getElementById('numPedido').value, document.getElementById('codCli').value, document.getElementById('tpVenda').value, document.getElementById('iemissao').value, document.getElementById('femissao').value)">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div>
    <div class="row">
      <div class="col">
      <div class="form-group">
        <label for="">N° Pedido</label>
        <input type="text" class="form-control campos"  style="width: 85px" id="numPedido">
      </div>
      <label for="">Cliente</label>
            <div class="input-group mb-3" style="width: 400px;">
                <div class="input-group-prepend" id="button-addon3">
                <input type="text" class="form-control campos" onchange="buscarClie(this.value)" style="width: 80px;" id="codCli">
                <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" style="width: 40px;" type="button" id="selecaoCli">...</button>
                </div>
                <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;"  placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
            </div>
      </div>
      <div class="col">
            <label for="">Emissão</label>
            <div class="row">
                <div class="col-md-auto">
                    <input type="date" name="" id="iemissao" class="form-control campos">
                </div>
                <div class="col-md-auto">até</div>
                <div class="col-md-auto">
                    <input type="date" name="" id="femissao" class="form-control campos">
                </div>
            </div> <br> 
            <div class="form-group">
                <label for="">Tipo de venda</label>
                <select name="tpVenda" id="tpVenda" class="form-control campos">
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
        </div>
    </div>
  <div id="pesquisar" style="margin-top: 2%"></div>
  </div>
  <!-- Fim Conteúdo -->
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
</body>
<script>
  
</script>
</html>