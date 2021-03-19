<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/modulos/cadastro/produto/cadastro/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="/owlsoftware/modulos/cadastro/produto/cadastro/js/dados.js"></script>
  <script src="/owlsoftware/modulos/cadastro/produto/cadastro/js/funcoes.js"></script>
  <!-- <script src="/owlsoftware/Modulos/Cadastro/produto/Consulta/js/funcoes.js"></script> -->
  
  <title>Produto</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Produto</h1>
    
    <div class="btn-toolbar" id="botoes" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" tabindex="4" onclick="confirmar()" class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisar()" >Pesquisar</button>
      </div>
    </div>
  </div>
   <!-- Inicio do formulario  -->
  <div id="form">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#cadastro">Cadastro</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#infoadicionais">Info. Adicionais</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#comentarios">Comentários</a>
      </li>
    </ul>
  
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="cadastro" class=" tab-pane active"><br>
        <div class="conteudo">
          <div class="esquerda" >
            <form action="">
              <input type="hidden" id="id">
              <div class="form-group">
                <label for="">Código</label>
                <input class="form-control campos" style="width: 150px;" type="text" id="cod">
              </div>
              <div class="form-group">
                <label for="">Tipo de produto</label>
                <select class="form-control campos" id="selecttprod">
                  <option value="#">Selecione</option>
                </select>
              </div>
      
              <div class="form-group">
                <label for="">Descrição</label>
                <input class="form-control campos" maxlength="240" style="width: 350px;" type="text" id="descricao">
              </div>
              <div class="form-group">
                <label for="">Referência</label>
                <input class="form-control campos" maxlength="240" style="width: 350px;" type="text" id="referencia">
              </div>
              <div class="form-group">
                <label for="">Grupo de produto</label>
                <select class="form-control campos" id="selectgprod">
                  <option value="#">Selecione</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Marca</label>
                <select class="form-control campos" id="selectmarca">
                  <option value="#">Selecione</option>
                </select>
              </div>
          </div>
          <div class="direita" >
            <div class="form-group">
              <label for="">Criação</label>
              <input type="date" class="form-control campos" value="<?php echo date("Y-m-d") ?>" disabled id="criacao">
            </div>
            <div class="form-group">
              <label for="">Atualização</label>
              <input type="date" class="form-control campos" value="<?php echo date("Y-m-d") ?>" disabled id="atualizacao">
            </div>
            <label  for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-bottom: 0px;" id="nomeusuario"><script>document.getElementById("nomeusuario").innerHTML = "Usuário de cadastro: <?php echo $_SESSION['usuario'];?>"</script></label> <br>
                 <label for="" style="color: rgb(110, 107, 107); font-size: 14px; margin-top: 0px;" id="nomeusuario2"> <script>document.getElementById("nomeusuario2").innerHTML = "Usuário de atualização: <?php echo $_SESSION['usuario'];?>"</script></label>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="inativo">
              <label class="custom-control-label" for="inativo">Inativo</label>
            </div>
            </form>
          </div>
        </div>

      </div>
      <div id="infoadicionais" class=" tab-pane fade"><br>
        <div class="conteudo">
          <div class="esquerda">
            <div class="form-group">
              <label for="">Preço Máximo</label>
              <input type="text" class="form-control campos" value="0,00" onkeyup="mascara(this)" id="preco_maximo">
            </div>
            <div class="form-group">
              <label for="">Preço Mínimo</label>
              <input type="text" class="form-control campos" value="0,00" onkeyup="mascara(this)" id="preco_minimo">
            </div>
           
          </div>
          <div class="direita">
            <div class="form-group">
              <label for="">Cor</label>
              <input type="text" class="form-control campos"  id="cor">
            </div>

          </div>
        </div>
        

      </div>
      <div id="comentarios" class=" tab-pane fade"><br>
        <div class="form-group">
          <label for="">Comentários</label>
          <textarea  id="comentario" cols="30" rows="5" class="form-control"></textarea>
          <button class="btn btn-success btn-add btn-square" onclick="addComentario()">Adicionar</button>
        </div>
        <div id="comentario_area" class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-striped mb-0" id="resultadoComentario">
            <thead>
              <th>ID</th>
              <th>Comentário</th>
              <th>#</th>
            </thead>
            <tbody id="tcorpo"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- fim do formulario -->
 </div>
</div>
</body>
<script>
  
</script>
</html>