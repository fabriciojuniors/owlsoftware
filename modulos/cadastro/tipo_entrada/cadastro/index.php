<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php'; 
    if(isset($_GET['i'])){
        $sql = "SELECT tp_entrada.*, usuario.usuario.nome as nome FROM tp_entrada INNER JOIN usuario.usuario WHERE codigo = $_GET[i] AND usuario.usuario.id = tp_entrada.usuario_criacao";
        $query = mysqli_query($link, $sql);
        if(mysqli_num_rows($query)>0){
            $row = mysqli_fetch_array($query);
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
    <script src="/owlsoftware/modulos/cadastro/tipo_entrada/cadastro/js/cadastro.js"></script>
    <title>Tipo de Entrada</title>
</head>
<body>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Tipo de Entrada</h1>
        
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
        <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
            <button type="button" id="confirmar" onclick="confirmar()"  class="btn btn-square btn-success">Confirmar</button>
        </div>
        <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
            <button type="button"  class="btn btn-square btn-light" onclick="window.location='/owlsoftware/modulos/index.php?pag=tipo_entrada'" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
        </div>
        <div class="btn-group" role="group" aria-label="Terceiro grupo">
            <button type="button" class="btn btn-primary btn-square" >Pesquisar</button>
        </div>
        </div>
  </div>

  <div id="formularioCad">
        <form>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Código</label>
                        <input type="text" id="cod" value="<?php echo (isset($row['codigo'])) ? $row['codigo'] :'' ;?>" name="cod" class="form-control campos" readonly style="width: 80px;">
                    </div>
                    <div class="form-group">
                        <label for="">Descrição</label>
                        <input type="text" id="descricao" value="<?php echo (isset($row['descricao'])) ? $row['descricao'] :'' ;?>" name="descricao" class="form-control campos">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" <?php echo (isset($row['gerar_financeiro']) && $row['gerar_financeiro'] == 1) ? 'checked' : '' ?> name="financeiro" id="financeiro" class="form-check-input">    
                        <label for="financeiro" class="form-check-label">Gerar financeiro</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" <?php echo (isset($row['inativo']) && $row['inativo'] == 1) ? 'checked' : '' ?> name="inativo" id="inativo" class="form-check-input">    
                        <label for="inativo" class="form-check-label">Inativo</label>
                    </div> <br>
                    <div class="form-group">
                        <label for="origem">Origem Movto. Estoque</label>
                        <select class="form-control campos" name="origem" id="origem">
                            <option value="#">Selecione</option>
                            <?php
                                $sql = "SELECT * FROM origem_estoque WHERE inativo = 0";
                                $query = mysqli_query($link, $sql);
                                while($rowO = mysqli_fetch_array($query)){
                                    ?>
                                        <option <?php echo (isset($row['origem_estoque']) && $rowO['id'] == $row['origem_estoque']) ? 'selected' : ''; ?> value="<?php echo $rowO['id']; ?>"><?php echo $rowO['descricao']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Data Criação</label>
                        <input type="date" id="criacao" name="criacao" value="<?php echo (isset($row['dt_criacao'])) ? $row['dt_criacao'] : date('Y-m-d');?>" class="form-control campos" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Data Atualização</label>
                        <input type="date" id="atualizacao" name="atualizacao" value="<?php echo date('Y-m-d');?>" class="form-control campos" readonly>
                    </div>
                    <p>Usuário criação: <span id="usuario_criacao"> <?php echo (isset($row['nome'])) ? $row['nome'] : $_SESSION['usuario']; ?></span> <br> Usuário criação: <span id="usuario_atualizacao"> <?php echo $_SESSION['usuario']; ?></span> </p>
                </div>
            </div>
        </form>
  </div>

  <div id="listagemCadastro" style="margin-top:5%; max-height: 400px; overflow-y: auto;">

                <?php
                    $sql = "SELECT * FROM tp_entrada";
                    $query = mysqli_query($link, $sql);
                    if(mysqli_num_rows($query) > 0){
                        ?>
                        <table class="table table-sm table-hover">
                            <thead>
                                <th>Códgo</th>
                                <th>Descricao</th>
                                <th>#</th>
                            </thead>
                            <tbody>
                        <?php
                        while($row = mysqli_fetch_array($query)){
                            ?>
                                <tr>
                                    <td <?php echo ($row['inativo'] == '1') ? 'style=color:red': '';?>><?php echo $row['codigo'];?></td>
                                    <td <?php echo ($row['inativo'] == '1') ? 'style=color:red': '';?>><?php echo $row['descricao'];?></td>
                                    <td ><a onclick="window.location.href = '/owlsoftware/modulos/index.php?pag=tipo_entrada&i=<?php echo $row['codigo'];?>'"><i class="fas fa-pen"></i></a></td>
                                </tr>
                            <?php
                        }
                    }else{
                        ?>
                            <div class="alert alert-danger" role="alert">Nenhum registro localizado</div>
                        <?php
                    }
                ?>
            </tbody>
      </table>
  </div>
</body>
</html>