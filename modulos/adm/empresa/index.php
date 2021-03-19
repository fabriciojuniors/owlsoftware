<?php include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
  <script src="/owlsoftware/modulos/adm/empresa/js/funcoes.js"></script>
  <title>Empresa de trabalho</title>
</head>
<body>
    
    <div class="container">
        <h1 class="h4 mb-0 text-gray-800">Empresa de trabalho</h1> <br>
        <form enctype="multipart/form-data" action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">CNPJ</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" required data-mask="00.000.000/0000-00" class="form-control campos" name="cnpj" id="cnpj">
                    </div>
                    <div class="form-group">
                        <label for="">Razão Social</label>
                        <input type="text" required id="razao" name="razao" class="campos form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nome Fantasia</label>
                        <input type="text" required id="fantasia" name="fantasia" class="campos form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Inscrição Estadual</label>
                        <input type="number" id="ie" name="ie" class="form-control campos">
                    </div>
                    <div class="form-group">
                        <label for="">Logo</label> <br>
                        <input type="file" id="logo" name="logo" class="campos">
                    </div>
                </div>
            </div>
            <input type="submit" value="Confirmar" class="btn btn-success btn-square" id="salvar">
        </form>
        <br> <br>
        <div class="row" style="max-height: 300px; overflow-y: auto">
            <table class="table table-sm table-hover">
                <thead>
                    <th>CNPJ</th>
                    <th>Razão Social</th>
                    <th>Nome Fantasia</th>
                    <th>#</th>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM empresa";
                        $query = mysqli_query($link, $sql);
                        if(mysqli_num_rows($query) > 0){
                            while($row = mysqli_fetch_array($query)){
                                ?>
                                    <tr>
                                        <td> <?php echo $row['cnpj'] ?> </td>
                                        <td> <?php echo $row['razao'] ?> </td>
                                        <td> <?php echo $row['fantasia'] ?> </td>
                                        <td> <a onclick="editarEmp(<?php echo $row['id'] ?>, '<?php echo $row['cnpj'] ?>', '<?php echo $row['razao'] ?>', '<?php echo $row['fantasia'] ?>', '<?php echo $row['ie'] ?>' )"> <i class="fas fa-pen"></i> </a> </td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
    
    if(isset($_POST['cnpj']) && isset($_POST['razao']) && isset($_POST['fantasia']) ){
        
        $cnpj = $_POST['cnpj'];
        $razao = $_POST['razao'];
        $fantasia = $_POST['fantasia'];
        $ie = (isset($_POST['ie'])) ? $_POST['ie'] : '';
        $id = (isset($_POST['id'])) ? $_POST['id'] : '';
        $diretorio = $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/modulos/adm/empresa/logo/';
        @$foto = basename($_FILES['logo']['name']);
        $arquivo = $diretorio . $foto;
        
        echo '<pre>';
        $sql = "SELECT * FROM empresa WHERE cnpj <> $cnpj";
        $query = mysqli_query($link, $sql);
        if(mysqli_num_rows($query) > 0){
            echo "<script> alert('Só é possível o cadastro de 1 empresa.')</script>";
        }else{
            if(move_uploaded_file($_FILES['logo']['tmp_name'], $arquivo)){
                if(!$id == ''){
                    $sql = "UPDATE empresa SET cnpj = '$cnpj', razao = '$razao', fantasia = '$fantasia', ie = '$ie', logo = '$foto' WHERE id = $id";
                }else{
                    $sql = "INSERT INTO empresa(cnpj, razao, fantasia, ie, logo) VALUE('$cnpj', '$razao', '$fantasia', '$ie', '$foto')";
                }
                
            }else{
                if(!$id == ''){
                    $sql = "UPDATE empresa SET cnpj = '$cnpj', razao = '$razao', fantasia = '$fantasia', ie = '$ie' WHERE id = $id";
                } else{
                    $sql = "INSERT INTO empresa(cnpj, razao, fantasia, ie) VALUE('$cnpj', '$razao', '$fantasia', '$ie')";
                }
                
            }
            
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            if($query){
                echo "<script>alert('Salvo com sucesso'); window.location.href = '/owlsoftware/modulos/index.php?pag=empresa'</script>";
            }else{
                echo "Erro ao salvar empresa. \n" . mysqli_error($link);
            }

        }


    }

?>