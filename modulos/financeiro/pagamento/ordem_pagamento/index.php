<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="/owlsoftware/modulos/financeiro/pagamento/ordem_pagamento/js/funcoes.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <title>Ordem de Pagamento</title>
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
    <h1 class="h4 mb-0 text-gray-800">Ordem de Pagamento</h1>
    
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button type="button" id="confirmar" onclick="confirmar()" class="btn btn-square btn-success">Confirmar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
        <button id="cancelar" class="btn btn-square btn-danger" onclick="validaCancelamento()" data-toggle="modal" data-target="#modalCancelamento">Cancelar</button>
      </div>
      <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
        <button type="button" onclick="limpar()" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);">Novo</button>
      </div>
      <div class="btn-group" role="group" aria-label="Terceiro grupo">
        <button type="button" class="btn btn-primary btn-square" onclick="pesquisar()">Pesquisar</button>
      </div>
    </div>
  </div>

  <!-- Conteúdo -->
  <div>
    <div class="conteudo">
      <div class="esquerda">
        <div class="form-group">
            <label for="">N° Ordem de pagamento</label>
            <div class="row" style="margin-left: 1px;">
                <input type="text" disabled class="form-control campos" style="width: 80px; margin-right:10px ;" id="nop"> 
                <p>/</p>
                <input type="text" disabled class="form-control campos" style="width: 80px; margin-left: 10px;" id="seqnop">
            </div>
        </div>
        <label for="">Fornecedor</label>
        <div class="input-group mb-3" style="width: 400px;">
            <div class="input-group-prepend" id="button-addon3">
              <input type="text" class="form-control campos" onchange="cliente(this.value)" style="width: 80px;" id="codCli">
              <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" id="selecaoCli" style="width: 40px;" type="button">...</button>
            </div>
            <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;"  placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
        </div>
        <div class="form-group">
          <label for="" title="Data de emissão da OR" >Emissão</label>
          <input type="date" name="" title="Data de emissão da OR" style="width: 150px;" id="emissao" value="<?php echo date("Y-m-d"); ?>" class="form-control campos campoDate">
        </div>
        <div class="form-group">
          <label for="">Vencimento</label>
          <input type="date" name="" disabled style="width: 150px;" id="vencimento" class="form-control campos campoDate">
        </div>
        <div class="form-group">
          <label for="">Valor</label>
          <div class="input-group mb-3" style="width: 250px;">
            <div class="input-group-prepend">
              <span class="input-group-text campos" style="width: 50px;" id="basic-addon1">R$</span>
            </div>
            <input type="text" =  id="valorTot" class="form-control campos">
          </div>
        </div>

        <div class="form-group">
          <label for="">Valor parcela</label>
          <div class="input-group mb-3" style="width: 250px;">
            <div class="input-group-prepend">
              <span class="input-group-text campos" style="width: 50px;" id="basic-addon1">R$</span>
            </div>
            <input type="text"  value="0,00" disabled id="valorParcela" class="form-control campos">
          </div>
        </div>
        <div class="form-group">
          <label for="">Condição de Pagamento</label>
          <select name="condpag" id="scondpag" class="form-control campos">
            <option value="#">Selecione</option>
          </select>
        </div>
      </div>
      <div class="direita">
        <div class="form-group">
          <label for="">Forma de Pagamento</label>
          <select name="" id="sformapag" class="form-control campos">
            <option value="#">Selecione</option>
          </select>
        </div>
        <div style="display: none;" class="form-group">
          <label for="">Conta bancária</label>
          <select name="" id="conta" class="form-control campos">
            <option value="#">Selecione</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Observações</label>
          <textarea class="form-control" name="" id="observacoes" cols="30" rows="10" style="width: 250px; height: 150px;"></textarea>
        </div>
        <div class="form-group">
          <a href="" onclick="verificaComentario()" id="verComentario" data-toggle="modal" data-target="#modalComentarios">Ver Comentários</a>
        </div>
      </div>
    </div>
  </div>
  <div id="resultado" style="margin-top: 15px; max-height: 250px; overflow-y: auto;">
    
  </div>
  <!-- Fim Conteúdo -->
</div>

<!-- Modal cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCliente">Seleção de Fornecedor</h5>
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


<!-- Modal Cancelamento -->
<div class="modal fade" id="modalCancelamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancelar ordem de pagamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Selecione a opção desejada</p>
        <div class="custom-control custom-radio">
          <input type="radio" id="selecionada" name="custoRadio" class="custom-control-input">
          <label class="custom-control-label" for="selecionada">Cancelar somente parcela selecionada.</label>
        </div>
        <div class="custom-control custom-radio">
          <input type="radio" id="todas" name="custoRadio" class="custom-control-input">
          <label class="custom-control-label" for="todas">Cancelas todas parcelas sem movimento.</label>
        </div> <br>
        <div class="row" id="dvSenha" style="margin-left: 1%; display: none;">
          <label for="" style="margin-right: 5px;">Senha: </label>
          <input type="password" class="form-control campos" id="senha">
          <div class="invalid-feedback">
            Senha inválida.
          </div>
          <div class="valid-feedback">
            Senha válida.
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-square" id="fechar" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-danger btn-square" onclick="cancelar()">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="comentario">Comentário</label>
          <textarea name="" id="comentario" cols="30" rows="3" class="form-control"></textarea>
        </div>
        <button id="addComentario" onclick="addComentario()" class="btn btn-square btn-success" style="float: right;">Adicionar</button> <br> <br>
        <div id="tabComentarios" style="max-height: 300px; overflow-y: auto;">
        
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" id="fecharComentario" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</body>
<script>
  
</script>
</html>