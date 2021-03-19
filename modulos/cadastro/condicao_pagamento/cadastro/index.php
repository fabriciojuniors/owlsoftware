<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="/owlsoftware/modulos/cadastro/condicao_pagamento/cadastro/js/funcoes.js"></script>
  <script src="/owlsoftware/modulos/cadastro/condicao_pagamento/consulta/js/funcoes.js"></script>
  
  <title>Condição de Pagamento</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Condição de Pagamento</h1>
    
    <div class="btn-toolbar" id="botoes" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="confirmar()" class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn  btn-primary" onclick="pesquisar()" style="display: none;">Pesquisar</button>
      </div>
    </div>
  </div>
    <form action="">
        <input type="text" style="display: none;" id="id">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Código</label>
                    <input type="text" id="codigo" name="cod" style="width: 150px; height: 30px;" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Criação</label>
                    <input type="date" id="dt_criacao" name="dt_criacao"  value="<?php echo date('Y-m-d');?>" disabled style="width: 200px; height: 30px;" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Descrição</label>
                    <input type="text" class="form-control" style="width: 250px; height: 30px;" id="descricao">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Atualização</label>
                    <input type="date" id="dt_atualizacao" value="<?php echo date('Y-m-d');?>" name="dt_atualizacao" disabled style="width: 200px; height: 30px;" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Parcela miníma</label>
                            <input type="text" value="0,00" onkeyup="formatarMoeda(this)" style="width: 200px; height: 30px;" class="form-control" id="parcela_minima">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Parcela máxima</label>
                            <input type="text" value="0,00" onkeyup="formatarMoeda(this)" style="width: 200px; height: 30px;" class="form-control" id="parcela_maxima">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <label  for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-bottom: 0px;" id="nomeusuario"><script>document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: <?php echo $_SESSION['usuario'];?>"</script></label> <br>
                 <label for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-top: 0px;" id="nomeusuario2"> <script>document.getElementById("nomeusuario2").innerHTML = "Usuário de atualização: <?php echo $_SESSION['usuario'];?>"</script></label>
                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="inativo">
                    <label class="custom-control-label" for="inativo">Inativo</label>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Condiçao</label>
                    <input type="text" style="width: 200px; height: 30px;"  placeholder="Exemplo: 30/60/90" class="form-control" id="condicao">
                </div>
            </div>
        </div>
    </form>
  <div id="pesquisar" style="margin-top: 30px; height:300px;">
    
  </div> </div>
</div>
</body>
<script>
  
</script>
</html>