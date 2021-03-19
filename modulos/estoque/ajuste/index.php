<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  
  <script src="/owlsoftware/modulos/estoque/ajuste/js/funcoes.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <title>Ajuste de estoque</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Ajuste de estoque</h1>
    
    <div class="btn-toolbar" id="botoes" style="margin-left: 0;" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="salvarAjuste()" class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <a href="/owlsoftware/modulos/estoque/ajuste/controller/impressao.php" target="_blank" class="btn btn-square btn-danger">Imprimir</a>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisar()">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div>
    <div id="superior">
      <div class="conteudo">
        <div class="esquerda">
          <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" disabled class="form-control campos"  style="width: 120px;" id="codigo" value="">
          </div>
          <div class="form-group">
            <label for="datamovto">Data</label>
            <input type="date" name="datamovto" id="datamovto" value="<?php echo date("Y-m-d") ?>" class="form-control campos">
          </div>
        </div>
        
        <div class="direita">
          <div class="form-group">
            <label for="observacao">Observações</label>
            <textarea name="observacao" id="observacao" cols="15" rows="4" class="form-control" maxlength="150" style="width: 350px;"></textarea>
          </div>
        </div>
      </div>
    </div>
    <hr style="width: 80%; align-items: center;">
    <div id="inferior" >
      <div class="conteudo">
        <div class="esquerda">
          <div class="form-group">
            <label for="">Tipo de movimento</label>
            <select disabled name="tpmovto" required id="tpmovto" class="form-control campos">
              <option value="#">Selecione</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Produto</label>
            <div class="form-row">
              <div class="col-sm-2">
                <input type="text" disabled class="form-control" onchange="buscaProd(this.value)" required placeholder="Código" style="height: 30px;" id="codprod">
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
            <div class="form-group">
              <label for="tamanho">Tamanho</label>
              <select name="" disabled id="selecttamanho" class="form-control campos">
                <option value="#">Selecione</option>
              </select>
            </div>
          </div>
          

        </div>
        <div class="direita">

          <div class="form-group">
            <label for="quantidade">Quantidade</label>
            <input type="text" disabled class="form-control campos" data-mask="000.000.000.000.000,00" data-mask-reverse="true"  id="quantidade">
          </div>
          <div class="form-group">
            <label for="">Custo</label>
            <div class="form-row">
              <div class="col-sm-2">
                <input type="text" disabled class="form-control" required style="height: 30px;" id="custo" data-mask="000.000.000.000.000,00" data-mask-reverse="true">
              </div>
              <div class="col-sm-2">
                <button id="adicionar" onclick="adicionar()" disabled class="btn btn-success btn-square">Adicionar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="listagem_ajuste" style="margin-top: 50px; max-height:200px; overflow-y:auto;">
        <table class="table" id="tabela_ajuste">
          <thead>
            <th>Código</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Custo</th>
            <th>Tamanho</th>
            <th>Excluir?</th>
          </thead>
          <tbody id="corpo_tabela_ajuste">
          </tbody>
        </table>
      </div>
    </div>
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