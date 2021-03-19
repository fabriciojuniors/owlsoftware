<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="../modulos/cadastro/produto/cadastro/css/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script src="../modulos/cadastro/cliente/cadastro/js/dados.js"></script>
  <script src="../modulos/cadastro/cliente/cadastro/js/funcoes.js"></script>
  <script src="../modulos/cadastro/cliente/cadastro/js/buscaCEP.js"></script>
  <!-- <script src="../Modulos/Cadastro/produto/Consulta/js/funcoes.js"></script> -->
  
  <title>Cliente</title>
</head>
<style>
</style>
<body>
<div id="conteudo" style="display: block;">
    
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Cliente</h1>
    
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
        <a class="nav-link" data-toggle="tab" href="#endereco">Endereço</a>
      </li>
    </ul>
  
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="cadastro" class=" tab-pane active"><br>
        <div class="conteudo">
          <div class="esquerda" >
            <form action="">
              <div class="form-group">
                <label for="">Código</label>
                <input type="text" disabled class="form-control campos" id="id">
              </div>
              <div class="form-group">
                <label for="">Código Webmais</label>
                <input type="text"  class="form-control campos" value="0" id="cod_webmais">
              </div>
              <div class="form-group">
                <label for="">CPF/CNPJ</label>
                <input class="form-control campos cpfcnpj" style="width: 150px;" type="text" id="cpfcnpj">
              </div>
              <div class="form-group">
                <label for="">Nome</label>
                <input type="text"  maxlength="240" style="width: 350px;" class="form-control campos" id="nome">
              </div>
      
              <div class="form-group">
                <label for="">Razão Social</label>
                <input class="form-control campos" maxlength="240" style="width: 350px;" type="text" id="razaosocial">
              </div>
              <div class="form-group">
                <label for="">Telefone</label>
                <input class="form-control campos phone_with_ddd"  style="width: 350px;" type="text" id="telefone">
              </div>
              <div class="form-group">
                <label for="">E-mail</label>
                <input type="email"  maxlength="240" style="width: 350px;" class="form-control campos" id="email">
              </div>

          </div>
          <div class="direita" >
            <div class="form-gorup">
              <label for="">Data de nascimento</label>
              <input type="date" class="form-control campos" id="datanascimento">
            </div>
            <div class="form-group">
              <label for="">Sexo</label>
              <select name="" id="sexo" class="form-control campos">
                <option value="#">Selecione</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
                <option value="N">Prefiro não informar</option>
              </select>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" name="" id="scliente" class="custom-control-input">
              <label class="custom-control-label" for="scliente">Cliente</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" name="" id="fornecedor" class="custom-control-input">
              <label class="custom-control-label" for="fornecedor">Fornecedor</label>
            </div> <br> <br>
            <div class="form-group">
              <label for="">Criação</label>
              <input type="text" class="form-control campos" value="<?php echo date("d/m/Y") ?>" disabled id="data_criacao">
            </div>
            <div class="form-group">
              <label for="">Atualização</label>
              <input type="text" class="form-control campos" value="<?php echo date("d/m/Y") ?>" disabled id="data_atualizacao">
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
      <div id="endereco" class=" tab-pane fade"><br>
        <div class="conteudo">
          <div class="esquerda">
            <div class="form-group">
              <label for="">CEP</label>
              <input type="text" class="form-control campos" onblur="pesquisacep(this.value);" data-mask="00000-000" id="cep">
            </div>
            <div class="form-group">
              <label for="">País</label>
              <select name="" id="selectpais" onchange="carregaUF(this.value)" class="form-control campos">
                <option value="#">Selecione</option>
              </select>
            </div>
            <div class="form-gorup">
              <label for="">UF</label>
              <select name="" id="selectuf" onchange="carregacidade(this.value)" class="form-control campos">
                <option value="#">Selecione</option>
              </select>
            </div>
            <div class="form-gorup">
              <label for="">Cidade</label>
              <select name="" id="selectcidade" class="form-control campos">
                <option value="#">Selecione</option>
              </select>
            </div>
          </div>
          <div class="direita">
            <div class="form-group">
              <label for="">Bairro</label>
              <input type="text" class="form-control campos"  id="bairro">
            </div>
            <div class="form-group">
              <label for="">Rua</label>
              <input type="text" class="form-control campos"  id="rua">
            </div>
            <div class="form-group">
              <label for="">Complemento</label>
              <input type="text" class="form-control campos"  id="complemento">
            </div>
          </div>
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