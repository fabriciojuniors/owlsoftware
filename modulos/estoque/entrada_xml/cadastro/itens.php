<script>
    $(document).ready(function($) {
        $('.money').mask('000.000.000.000.000,00', {
            reverse: true
        });
    })
</script>
<div id="itensXML" style="margin-top: 1%; max-height: 300px; overflow-y: auto;">
    <table class="table table-sm table-hover" id="tab-ItensXML">
        <thead>
            <th style="width: 7%;">Cod. XML</th>
            <th style="width: 15%;">Desc. XML</th>
            <th style="width: 7%;">Qtd. XML</th>
            <th style="width: 10%;">Val. Unit. XML</th>
            <th style="width: 40%;">Produto</th>
            <th>Qtd.</th>
            <th style="text-align: center;">Movimentar?</th>
        </thead>
        <tbody id="corpoItensXML">
            <?php
            $arquivo = $uploaddir . $_SESSION['arquivoXML'];
            $arquivo_xml = simplexml_load_file($arquivo);
            $i = 1;
            foreach ($arquivo_xml->NFe->infNFe->det as $produto) {
            ?>
                <tr>
                    <td> <?php echo $produto->prod->cProd; ?> <input type="hidden" name="codProdXML" value="<?php echo $produto->prod->cProd; ?>" id="codProdXML<?php echo $i ?>"> </td>
                    <td> <?php echo $produto->prod->xProd; ?> </td>
                    <td> <?php echo number_format((float)$produto->prod->qCom, 2, ',', '.'); ?> </td>
                    <td> <?php echo "R$" . number_format((float)$produto->prod->vProd, 2, ',', '.'); ?> <input type="hidden" value="<?php echo number_format((float)$produto->prod->vProd, 2, ',', '.'); ?>" id="valUnit<?php echo $i ?>"> </td>
                    <td><input type="hidden" id="idItemPedido">
                        <div class="input-group mb-3" style="width: 400px;">
                            <div class="input-group-prepend" id="button-addon3">
                                <input type="text" class="form-control campos" onchange="buscarProduto(this.value, <?php echo ($i - 1) ?>)" style="width: 80px;" id="codProd<?php echo $i ?>">
                                <button class="btn btn-outline-secondary btn-square campos" onclick="selecaoProd(document.querySelector('#s_indice').value = <?php echo $i ?>)" data-toggle="modal" data-target="#modalProduto" style="width: 40px;" type="button" id="selecaoProd">...</button>
                            </div>
                            <input type="text" disabled class="form-control campos" id="descprod<?php echo $i ?>" style="width: 10px;" placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
                        </div>
                    </td>
                    <td> <input style="width: 80px;" type="text" value="<?php echo number_format((float)$produto->prod->qCom, 2, ',', '.'); ?>" class="form-control campos money" id="qtdmov<?php echo $i ?>"> </td>
                    <td style="text-align: center;"> <input type="checkbox" id="movimentar<?php echo $i ?>"> </td>
                </tr>


            <?php
                $i++;
            }
            ?>
            <input type="hidden" name="qtdTotalItem" value="<?php echo $i; ?>" id="qtdTotalItem">
        </tbody>
    </table>
</div>
<div style="float: right; margin-right: 2%;" class="row">
    <button onclick="adicionarItens()" class="btn btn-success btn-square">Adicionar</button>
</div>
<!-- Modal Seleção do produto -->
<div class="modal" id="modalProduto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produto</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="selecaoProd">
                    <form action="" id="selecaoProd">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Descrição</label>
                                        <input type="text" class="form-control" id="s_descricao">
                                        <input type="hidden" name="s_indice" id="s_indice">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Grupo</label>
                                        <select name="" id="g_prod" class="form-control">
                                            <option value="#">Selecione</option>
                                            <?php
                                            $sql = "SELECT * FROM grupo_produto WHERE inativo = 0";
                                            $query = mysqli_query($link, $sql);
                                            if (mysqli_num_rows($query) > 0) {
                                                while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['descricao']  ?></option>
                                            <?php
                                                };
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Tipo</label>
                                        <select name="" id="t_prod" class="form-control">
                                            <option value="#">Selecione</option>
                                            <?php
                                            $sql = "SELECT * FROM tipo_produto WHERE inativo = 0";
                                            $query = mysqli_query($link, $sql);
                                            if (mysqli_num_rows($query) > 0) {
                                                while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['descricao']  ?></option>
                                            <?php
                                                };
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <script>
                                selecaoProd(document.querySelector('#s_indice').value)
                            </script>
                            <input type="button" onclick="selecaoProd(document.querySelector('#s_indice').value)" value="Pesquisar" class="btn btn-primary btn-square">
                        </div>
                    </form>
                    <div id="resultado" style="margin-top: 5%; max-height:300px; overflow-y:auto;">
                        <table class="table" id="resultado_produtos" style="align-content:center;">

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-square" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>