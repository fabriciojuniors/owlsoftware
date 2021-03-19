<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
<script src="/owlsoftware/modulos/vendas/nf_pedido/consulta/js/funcoes.js"></script>
<title>Consulta NF</title>
<div style="float: right;" class="row">
    <div class="col-sm"><button id="pesquisar" onclick="pesquisarNota(1)" class="btn btn-square btn-primary">Pesquisar</button></div> 
    <div class="col-sm"><button id="pesquisar" class="btn btn-square btn-success">Limpar</button></div>
</div>
<h4>Consulta NF</h4>

<div class="row" id="form-pesquisa">
        <div class="col">
            <div class="form-group">
                <label for="">Nota:</label>
                <input type="text" style="width: 80px" class="form-control campos" id="numNF">
            </div>
            <div class="form-group">
                <label for="">Pedido:</label>
                <input type="text" style="width: 80px" class="form-control campos" id="numPedido">
            </div>
        </div>
        <div class="col">
            <label for="">Cliente</label>
            <div class="input-group mb-3" style="width: 400px;">
                <div class="input-group-prepend" id="button-addon3">
                <input type="text" class="form-control campos" onchange="buscarClie(this.value)" style="width: 80px;" id="codCli">
                <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" style="width: 40px;" type="button" id="selecaoCli">...</button>
                </div>
                <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;"  placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
            </div>
            <label for="">Emissão</label>
            <div class="row">
                <div class="col-md-auto">
                    <input type="date" name="" id="iemissao" class="form-control campos">
                </div>
                <div class="col-md-auto">até</div>
                <div class="col-md-auto">
                    <input type="date" name="" id="femissao" class="form-control campos">
                </div>
            </div>
        </div>
</div>
<br>
<div class="row" style="margin-left: 1%; margin-right: 1%" id="pesquisarNF"></div>


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
<input type="hidden" value="ASC" id="orderDesc">
<input type="hidden" value="nota_fiscal.numero" id="order">