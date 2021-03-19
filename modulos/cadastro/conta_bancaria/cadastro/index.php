<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <script src="/owlsoftware/modulos/cadastro/conta_bancaria/cadastro/js/funcoes.js"></script>
  <script src="/owlsoftware/modulos/cadastro/conta_bancaria/consulta/js/funcoes.js"></script>
  
  <title>Conta Bancária</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Conta Bancária</h1>
    
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
          <input type="hidden"  id="id">
          <div class="row">
              <div class="col">
                  <div class="form-group">
                      <label for="">Código</label>
                      <input type="text" disabled class="form-control" style="width: 200px; height: 30px;" id="codigo">
                  </div>
              </div>
              <div class="col">
                  <div class="form-group">
                      <label for="">Criação</label>
                      <input type="date" disabled class="form-control" value="<?php echo date('Y-m-d');?>" style="width: 200px; height: 30px;" id="dt_criacao">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col">
                  <div class="form-group">
                      <label for="">Portador</label>
                      <select name="" id="portador" style="width: 200px; height: 30px;" class="form-control">
                          <option value="#">Selecione</option>
                      </select>
                  </div>
              </div>
              <div class="col">
                  <div class="form-group">
                      <label for="">Atualização</label>
                      <input type="date" disabled id="dt_atualizacao" value="<?php echo date('Y-m-d');?>" style="width: 200px; height: 30px;" class="form-control">
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col">
                  <div class="row">
                      <div class="col">
                          <div class="form-group">
                              <div class="row">
                                  <div class="col">
                                    <label for="">Agência</label>
                                    <input type="number" id="agencia" style="height: 30px;" class="form-control">
                                  </div>
                                  <div class="col">
                                      <label for="">DV</label>
                                      <input type="number" id="dvagencia" style="height: 30px;" class="form-control">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col">
                          <div style="width: 100%;" class="form-group">
                              
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col">
                  <div class="form-group">
                    <label  for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-bottom: 0px;" id="nomeusuario"><script>document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: <?php echo $_SESSION['usuario'];?>"</script></label> <br>
                    <label for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-top: 0px;" id="nomeusuario2"> <script>document.getElementById("nomeusuario2").innerHTML = "Usuário de atualização: <?php echo $_SESSION['usuario'];?>"</script></label>
                      <div class="custom-control custom-checkbox my-1 mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="inativo">
                        <label class="custom-control-label" for="inativo">Inativo</label>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col">
                  <div class="row">
                      <div class="col">
                          <div class="form-group">
                              <div class="row">
                                  <div class="col">
                                      <label for="">Conta</label>
                                      <input type="number" class="form-control" style="height: 30px;" id="conta">
                                  </div>
                                  <div class="col">
                                      <label for="">DV</label>
                                      <input type="number" id="dvconta" style="height: 30px;" class="form-control">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col" style="width: 100%;"></div>
                  </div>
              </div>
              <div class="col" style="width: 100%;"></div>
          </div>
          <div class="row">
              <div class="col">
                <div class="form-group">
                    <label for="">Titular</label>
                    <input type="text" class="form-control" style="width: 350px; height: 30px;" id="titular">
                </div>
              </div>
              <div class="col" style="width: 100%;"></div>
          </div>
      </form>
  </div>

  <div id="pesquisar" style="margin-top: 30px; height:300px;">
    
  </div> </div>
</div>
</body>
</html>