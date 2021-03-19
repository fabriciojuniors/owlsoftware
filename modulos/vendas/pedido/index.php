<?php
include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="/owlsoftware/modulos/vendas/pedido/js/funcoes.js"></script>
  <script src="/owlsoftware/modulos/vendas/pedido/js/salvarPedido.js"></script>
  <script src="/owlsoftware/common/js/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
  <title>Pedido de Venda</title>
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
    <h1 class="h4 mb-0 text-gray-800">Pedido de Venda</h1>
    
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="salvarPedido()"  class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limparPedido()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisarPedido()">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div>
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="cadastro-tab" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="true">Cadastro</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="itens-tab" data-toggle="tab" href="#itens" role="tab" aria-controls="itens" aria-selected="false">Itens</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="finalizacao-tab" data-toggle="tab" href="#finalizacao" role="tab" aria-controls="finalizacao" aria-selected="false">Finalização</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
        <?php include('cadastro.php')?>
  </div>
  <div class="tab-pane fade" id="itens" role="tabpanel" aria-labelledby="itens-tab"> <?php include('itens.php')?></div>
  <div class="tab-pane fade" id="finalizacao" role="tabpanel" aria-labelledby="finalizacao-tab"> <?php include('finalizacao.php') ?> </div>
</div>
  </div>
  <!-- Fim Conteúdo -->


</body>
<script>
  
</script>
</html>