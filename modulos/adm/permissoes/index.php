<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
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
  <script src="/owlsoftware/modulos/adm/permissoes/js/permissoes.js"></script>
  <script src="/owlsoftware/modulos/adm/permissoes/js/salvarPermissao.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
  <title>Permissões de acesso</title>
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
    <h1 class="h4 mb-0 text-gray-800">Permissões de acesso</h1>
    
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="salvarPermissao()"  class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="display:none; border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" style="display:none;">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div class="row">
    <div class="col-sm" id="selecaoUsuario">
        <label for="sUsuario">Usuários: </label>
        <select class="form-control campos" name="sUsuario" id="sUsuario">
            <option value="">Selecione</option>
            <?php
                mysqli_select_db($link, "usuario");
                $sql = "SELECT * FROM usuario WHERE namespace = '$_SESSION[namespace]'";
                echo $sql;
                $query = mysqli_query($link, $sql);
                while($row = mysqli_fetch_array($query)){
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['nome'] ?></option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div class="col-sm">
        <label for="">Módulo:</label>
        <select class="form-control campos" onchange="permissoes(document.getElementById('sUsuario').value, document.getElementById('sModulos').value)" name="sModulo" id="sModulos">
            <option value="#">Selecione</option>
            <?php
                mysqli_select_db($link, $_SESSION['namespace']);
                $sql = "SELECT * FROM modulos";
                $query = mysqli_query($link, $sql);
                while($row = mysqli_fetch_array($query)){
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['nome'])?></option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div class="col-md" style="max-height: 350px; overflow-y: auto; width: 10px" id="dvtelas">
        
    </div>
  </div>
  <!-- Fim Conteúdo -->
</body>
<script>
  
</script>
</html>