<?php include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php'; @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
    <script src="/owlsoftware/modulos/vendas/nf_devolucao/js/buscaNF.js"></script>
    <script src="/owlsoftware/modulos/vendas/nf_devolucao/js/funcoes.js"></script>
    <script src="/owlsoftware/modulos/vendas/nf_devolucao/js/salvarNFDev.js"></script>
    <script src="/owlsoftware/modulos/vendas/nf_devolucao/js/adicionarItens.js"></script>
    <script src="/owlsoftware/modulos/vendas/nf_devolucao/js/finalizarDevolucao.js"></script>
    <title>Devolução</title>
</head>
<body>  
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Devolução</h1>
    
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="salvarNFDev()"  class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="window.location.reload()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="window.location.href = '/owlsoftware/modulos/index.php?pag=consulta_nf_pedido'">Pesquisar</button>
      </div>
    </div>
</div>
    
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="tab-cadastro-dev" data-toggle="tab" href="#cadastroDev" role="tab" aria-controls="nav-home" aria-selected="true">Cadastro</a>
        <a class="nav-item nav-link disabled" onclick="carregaItens()" id="tab-itens" data-toggle="tab" href="#itens" role="tab" aria-controls="nav-profile" aria-selected="false">Itens</a>
        <!-- <a class="nav-item nav-link disabled" id="tab-finalizar" data-toggle="tab" href="#finalizar" role="tab" aria-controls="nav-contact" aria-selected="false">Finalizar</a> -->
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="cadastroDev" role="tabpanel" aria-labelledby="tab-cadastro-dev"><?php include('cadastro.php') ?></div>
  <div class="tab-pane fade" id="itens" role="tabpanel" aria-labelledby="tab-itens"><?php include('itens.php') ?></div>
  <div class="tab-pane fade" id="finalizar" role="tabpanel" aria-labelledby="tab-finalizar"><?php include('finalizar.php') ?></div>
</div>
</body>
</html>