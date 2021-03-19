<div id="nota" style="margin-top: 2%;">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <form action="" id="enviaXML" method="post" enctype="multipart/form-data">
                    <label for="">Arquivo XML:</label>
                    <input type="file" name="arquivoXML" onchange="carregarXML()" accept=".xml" id="arquivoMXL">
                </form>
                <input type="hidden" name="nomeArquivo" value="<?php echo (isset( $row['arquivo_xml'])) ? $row['arquivo_xml'] : '' ?>" id="nomeArquivo">
                <?php if(isset($row['arquivo_xml'])) $_SESSION['arquivoXML'] = $row['arquivo_xml']; ?>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Chave de acesso</label>
                        <input type="text" class="form-control campos" value="<?php echo (isset( $row['chave'])) ? $row['chave'] : '' ?>" id="chave">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Número</label>
                        <input type="text" class="form-control campos" id="numero" value="<?php echo (isset( $row['numero'])) ? $row['numero'] : '' ?>" style="width: 90px;">
                        <input type="hidden" name="idNota" id="idNota" value="<?php echo (isset( $row['id'])) ? $row['id'] : '' ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="">Tipo de Entrada</label>
                <select class="form-control campos" name="tp_entrada" id="tp_entrada">
                    <option value="#">Selecione</option>
                    <?php
                    $sql = "SELECT * FROM tp_entrada WHERE inativo <> 1";
                    $query = mysqli_query($link, $sql);
                    if (mysqli_num_rows($query) > 0) {
                        while ($rowTp = mysqli_fetch_array($query)) {
                    ?>
                            <option <?php if(isset($row['tp_entrada']) && $rowTp['id'] == $row['tp_entrada']) echo "selected" ?> value="<?php echo $rowTp['id']; ?>"><?php echo $rowTp['descricao']; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <label for="">Fornecedor</label>
            <div class="input-group mb-3" style="width: 400px;">
                <div class="input-group-prepend" id="button-addon3">
                    <script> buscarClie(value="<?php echo ($row['fornecedor']) ? $row['fornecedor'] : '' ?>") </script>
                    <input type="text" class="form-control campos" onchange="buscarClie(this.value)" style="width: 80px;" id="codCli">
                    <button class="btn btn-outline-secondary btn-square campos" data-toggle="modal" data-target="#modalCliente" style="width: 40px;" type="button" id="selecaoCli">...</button>
                </div>
                <input type="text" disabled class="form-control campos" id="nomeCli" style="width: 10px;" placeholder="" aria-label="Example text with two button addons" aria-describedby="button-addon3">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Emissão</label>
                <input type="date" name="emissao" value="<?php echo ($row['emissao']) ? $row['emissao'] : '' ?>" id="emissao" class="form-control campos">
            </div>
            <div class="form-group">
                <label for="">Entrada</label>
                <input type="date" name="entrada" value="<?php echo ($row['entrada']) ? $row['entrada'] : '' ?>" id="entrada" class="form-control campos">
            </div>
        </div>
    </div>
</div>

<!-- Modal Cliente -->
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

<?php
    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/modulos/estoque/entrada_xml/cadastro/XMLs/';
    if(isset($_FILES['arquivoXML'])){
        $uploadfile = $uploaddir . basename($_FILES['arquivoXML']['name']);
        echo '<pre>';
        if (move_uploaded_file($_FILES['arquivoXML']['tmp_name'], $uploadfile)) {
            $arquivo = $uploaddir.$_FILES['arquivoXML']['name'];
            $arquivo_xml = simplexml_load_file($arquivo);
            $nomeArquivo = $_FILES['arquivoXML']['name'];
            $chave =$arquivo_xml->protNFe->infProt->chNFe;
            $numero = $arquivo_xml->NFe->infNFe->ide->nNF;
            $fornecedor = $arquivo_xml->NFe->infNFe->emit->CNPJ;
            $emissao = $arquivo_xml->NFe->infNFe->ide->dhEmi;
            $entrada = $arquivo_xml->NFe->infNFe->ide->dhSaiEnt;
            echo "<script>
                document.getElementById('chave').value = '$chave';
                document.getElementById('numero').value = $numero;
                document.getElementById('nomeArquivo').value = '$nomeArquivo';
                document.getElementById('emissao').value=moment('$emissao').utc().format('YYYY-MM-DD');
                document.getElementById('entrada').value=moment('$entrada').utc().format('YYYY-MM-DD');
                pesquisarFornXML($fornecedor);
            </script>";
        }
    }

?>