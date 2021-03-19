<?php include $_SERVER['DOCUMENT_ROOT'] . '/owlsoftware/conexao.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">

  <script src="/owlsoftware/modulos/vendas/relatorio/nf_canceladas/js/gerar.js"></script>
  <script src="/owlsoftware/modulos/vendas/relatorio/nf_canceladas/js/funcoes.js"></script>
  <title>Rel. Notas Fiscais Canceladas</title>
</head>

<body>
  <h4>Rel. Notas Fiscais Canceladas</h4>
  <form class="" action="/owlsoftware/modulos/vendas/relatorio/nf_canceladas/controller/relFat02.php" onsubmit="target_popup(this)" method="post">
    <label for="">Emissão</label>
    <div class="row">
      <div class="col-md-auto" style="padding-right: 0%">
        <input type="date" required name="iemissao" value="<?php echo date("Y-m-d", strtotime('-30 days')); ?>" id="iemissao" class="form-control campos">
      </div>
      <div class="col-md-auto">até</div>
      <div class="col-md-auto" style="padding: 0%">
        <input type="date" required name="femissao" value="<?php echo date("Y-m-d"); ?>" id="femissao" class="form-control campos">
      </div>
    </div>
    <label for="">Cliente</label>
    <div class="input-group mb-3" style="width: 400px;">
      <div class="input-group-prepend" id="button-addon3">
        <input type="text" class="form-control campos" onchange="buscarClie(this.value)" style="width: 80px;" name="codCli" id="codCli">
        <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" style="width: 40px;" type="button" id="selecaoCli">...</button>
      </div>
      <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;" placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
    </div>

    <div class="row" style="margin-bottom: 10px;">
      <div class="col-md-auto"><label for="">Ordenação</label>
        <select class="form-control campos" name="ordenacao" id="ordenacao">
          <option value="nota_fiscal.numero">Nota Fiscal</option>
          <option value="pedidos.numero">Pedido de Venda</option>
          <option value="clientes.id">Clientes</option>
          <option value="nota_fiscal.emissao">Emissão (NF)</option>
          <option value="nota_fiscal.entrega">Entrega (NF)</option>
        </select>
      </div>
    </div>

    <div class="dropdown">
      <label for="" style="margin-right: 5px">Tipo de Venda</label><i class="fas fa-plus dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php
        $sql = "SELECT * FROM tp_venda WHERE inativo = 0";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        if (mysqli_num_rows($query) > 0) {
          while ($row = mysqli_fetch_array($query)) {
        ?>
            <div class="dropdown-item">
              <div class="form-check">
                <input class="form-check-input" checked type="checkbox" value="<?php echo $row['id']; ?>" name="tpVenda<?php echo $row['id']; ?>" id="tpVenda<?php echo $row['id']; ?>">
                <label class="form-check-label" for="tpVenda<?php echo $row['id']; ?>">
                  <?php echo $row['descricao']; ?>
                </label>
              </div>
            </div>

        <?php
          }
        }
        ?>
      </div>
    </div>



    <input class="btn btn-success btn-square" type="submit" value="Gerar">
  </form>
</body>

<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCliente">Seleção de Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <label for="">CPF/CNPJ</label>
            <input type="text" class="form-control campos" id="cpfcnpj">
          </div>
          <div class="col">
            <label for="">Nome</label>
            <input type="text" class="form-control campos" id="nome">
          </div>
        </div>
        <button style="margin-top: 10px;" class="btn btn-primary btn-square" id="pesquisarCli" onclick="pesquisarCli()">Pesquisar</button>

        <div id="divResultado" style="max-height: 400px; overflow-y: auto; margin-top: 15px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

</html>