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
              <table class="table" id="resultado_produtos" style="align-content:center;">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Descrição</th>
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
                <td>  <a onclick="buscarProdutoM('<?php echo $row['cod'] ?>', <?php echo ($dados['indice'])?>)" data-dismiss="modal"><i class="fas fa-check"></i></a></td>
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