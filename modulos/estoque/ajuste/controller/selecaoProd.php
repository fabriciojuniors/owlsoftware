<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $desc = $dados['descricao'];
    $grupo = $dados['grupo'];
    $tipo = $dados['tipo'];

    if($grupo == '#'){
        $grupo = null;
    }
    if($tipo == '#'){
        $tipo = null;
    }

    $sql = "SELECT * FROM produto WHERE descricao like '%$desc%' and tipo_produto like '%$tipo%' and grupo_produto like '%$grupo%' ORDER BY cod";
    $quert = mysqli_query($link, $sql) or die(mysqli_error($link));
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
              <table class="table" id="resultado_produtos" style="align-content:center;">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Custo</th>
                    <th>Tamanho</th>
                    <th>Movimentar?</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>

              
<?php
    if(mysqli_num_rows($quert)>0){
        $i =1;
        while($row = mysqli_fetch_array($quert)){
           ?>
            <tr>
                <td id="codigo"><?php echo $row['cod'] ?></td>
                <td><span id="descricao"><?php echo $row['descricao']  ?></span></td>
                <td><input type="number" class="form-control" style="width: 80px;" data-mask="0.000.000.000,00" data-mask-reverse="true" id="quantidade<?php echo $row['cod']?>"></td>
                <td><input type="number" class="form-control" style="width: 80px;" data-mask="0.000.000.000,00" data-mask-reverse="true" id="custo<?php echo $row['cod']?>"></td>
                <td><select name="" id="tamanhoModal<?php echo $row['cod']?>"class="form-control">
                    <option value="#">Selecione</option>
                        <?php
                            $sqlTamanho = "SELECT * FROM tamanho WHERE inativo = 0";
                            $queryTamanho = mysqli_query($link, $sqlTamanho) or die(mysqli_error($link));
                            while($rowTamanho = mysqli_fetch_array($queryTamanho)){
                                ?>
                                    <option value="<?php echo $rowTamanho['id'] ?>"><?php echo $rowTamanho['descricao']?></option>
                                <?php
                            }
                        ?>
                </select></td>
                <td><input type="checkbox" style="margin-left: 30px;"  name="" onclick="movimentarEstoque('<?php echo $row['cod'] ?>', document.getElementById('quantidade'+'<?php echo $row['cod']?>').value, document.getElementById('custo'+'<?php echo $row['cod']?>').value, document.getElementById('tamanhoModal'+'<?php echo $row['cod']?>').value, document.getElementById('tpmovto').value, document.getElementById('codigo').value)" id="movimentar<?php echo $row['cod']?>"></td>
                <td>  <a title="Desabilitado. Estoque não adicionado para o produto." style="pointer-events: none;" href="" onclick="excluirMovto('<?php echo $row['cod'] ?>')" id="excluir<?php echo $row['cod']?>" ><i class="fas fa-trash-alt"></i></a></td>
            </tr>
           <?php 
        }
?>
    </tbody>
    </table>
<?php
    } else{
        echo "Nenhum produto localizado.";
    }
?>