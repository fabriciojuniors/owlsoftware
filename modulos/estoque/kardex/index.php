<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="/owlsoftware/modulos/estoque/kardex/js/funcoes.js"></script>
  
  <title>Kardex</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Kardex</h1>
    
    <div class="btn-toolbar" id="botoes" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="pesquisar" onclick="pesquisar()" class="btn btn-square btn-success">Pesquisar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisar()" style="display: none;">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div>
    <div class="conteudo">
      <div class="esquerda">
        <label for="">Período</label>
        <div class="form-row">
            <div class="col-sm-3">
              <input type="date"  class="form-control" placeholder="" value="<?php echo date('Y-m-d'); ?>" style="height: 30px;" id="dtinicial">
            </div>
            à
            <div class="col-sm-3">
              <input type="date" id="dtfinal" class="form-control" value="<?php echo date('Y-m-d'); ?>" style="height: 30px;">
            </div>
          </div>
        <div class="form-group">
          <label for="">Produto</label>
          <div class="form-row">
            <div class="col-sm-2">
              <input type="text" class="form-control" onchange="buscaProd(this.value)" required placeholder="Código" style="height: 30px;" id="codprod">
            </div>
            <div class="col">
              <input type="text" readonly id="descprod" class="form-control" style="height: 30px;">
            </div>
            <div class="col-sm-2">
              <a href="" id="lupaProd" style="pointer-events: none;" data-toggle="modal" onclick="carregaInfo()" data-target="#modalProduto">
                <i class="fas fa-search"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="direita">
        <label for="">Tamanho</label>
        <div class="form-row">
          <select name="tamanho" class="form-control campos" id="selecttamanho">
            <option value="#">Selecione</option>
          </select>
          </div>
        <div class="form-group">
          <label for="">Tipo de movimento</label>
          <div class="form-row">
            <div class="col-sm-2">
              <select name="tpmovto" class="form-control campos" id="selecttpmovto">
                <option value="#">Selecione</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="resultado_kardex" style="max-height: 350px; overflow-y: auto;"></div>
    <div id="qtdEntrada"></div>
    <div id="qtdSaida"></div>
  </div>
  <!-- Fim Conteúdo -->

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
                    </select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" id="t_prod" class="form-control">
                      <option value="#">Selecione</option>
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
<!-- Fim do Modal de produto -->

</div>
</body>
<script>
  
</script>
</html>