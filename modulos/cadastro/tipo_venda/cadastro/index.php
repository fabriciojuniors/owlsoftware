<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="/owlsoftware/modulos/cadastro/tipo_venda/cadastro/js/funcoes.js"></script>
  <script src="/owlsoftware/modulos/cadastro/tipo_venda/consulta/js/funcoes.js"></script>
  
  <title>Tipo de Venda</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Tipo de Venda</h1>
    
    <div class="btn-toolbar" id="botoes" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" tabindex="4" onclick="confirmar()" class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisar()" style="display: none;">Pesquisar</button>
      </div>
    </div>
  </div>
    
  <div id="form">
    <form action="" id="formulario" method="post">
      <input type="text" style="display: none;" id="id">
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="">Código</label>
            <input type="text" id="codigo" disabled="disabled" style="width: 150px; height: 34px;" class="form-control">
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="">Criação</label>
            <input type="date" value="<?php echo date('Y-m-d');?>" name="dt_criacao" disabled style="width: 200px; height: 34px;" id="dt_criacao" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="row">
              <div class="col">
                  <div class="form-group">
                      <label for="">Descrição</label>
                      <input type="text" style="width: 300px; height: 30px;" tabindex="1" class="form-control" id="descricao">
                  </div>
              </div>
          </div>
      </div>

        <div class="col">
          <div class="form-group">
            <label for="">Atualização</label>
            <input type="date" value="<?php echo date('Y-m-d');?>" id="dt_atualizacao" disabled class="form-control" style="width: 200px; height: 34px;" >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="row">
              <div class="col">
                  <div class="form-group">
                      <label for="">Origem movto. Estoque</label>
                      <select name="" id="origemmovto" class="form-control" style="width: 200px; height: 30px;">
                        <option value="#">Selecione</option>
                      </select>
                  </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="">Tipo movto. Estoque</label>
                  <select name="uf" id="tipomovto" class="form-control" style="width: 200px; height: 30px;">
                    <option value="#">Selecione</option>
                  </select>
              </div>
              </div>
          </div>
      </div>

        <div class="col">
            <label  for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-bottom: 0px;" id="nomeusuario"><script>document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: <?php echo $_SESSION['usuario'];?>"</script></label> <br>
             <label for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-top: 0px;" id="nomeusuario2"> <script>document.getElementById("nomeusuario2").innerHTML = "Usuário de atualização: <?php echo $_SESSION['usuario'];?>"</script></label>
             <div class="custom-control custom-checkbox my-1 mr-sm-2">
              <input type="checkbox" class="custom-control-input" id="inativo" tabindex="3">
              <label class="custom-control-label" for="inativo">Inativo</label>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-auto">
            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                <input type="checkbox" class="custom-control-input" id="financeiro" tabindex="3">
                <label class="custom-control-label" for="financeiro">Gerar financeiro</label>
            </div> 
        </div>
        <div class="col-md-auto">
          <div class="custom-control custom-checkbox my-1 mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="devolucao" tabindex="3">
            <label class="custom-control-label" for="devolucao">Devolução</label>
        </div> 
        </div>
    </div>
      <button type="submit" id="btnsubmit" style="display: none;"></button>
    </form>
  </div>

  <div id="pesquisar" style="margin-top: 30px; height:300px;">
    
  </div> </div>
</div>
</body>
<script>
  
</script>
</html>