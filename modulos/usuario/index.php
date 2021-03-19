<?php
include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
include_once "liberaTodosS.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
    <script src="/owlsoftware/modulos/Usuario/js/funcoes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Usuário</title>
</head>
<body>
    <div class="container">
        <form method="post" id="formularioUsuario" action="" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <input type="hidden" name="idUsuario" id="idUsuario">
                    <label for="">Nome</label>
                        <input type="text" required class="form-control campos" name="nome" id="nome">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="email" required name="email" id="email" class="form-control campos">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Data de nascimento</label>
                        <input type="date" required name="datanascimento" id="datanascimento" class="form-control campos">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Login</label>
                        <input type="text" required id="login" name="login" class="form-control campos">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Foto de perfil</label> <br>
                        <input type="file" name="fotoperfil" id="fotoperfil" class="campos">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Senha</label>
                        <input type="password" required name="senha" id="senha" class="form-control campos">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-square btn-success" id="salvar">Salvar</button>
            <button type="reset" class="btn btn-square btn-light" style="border: 1px solid rgb(110, 107, 107);" id="limpar">Limpar</button>
        </form>

        <div style="margin-top: 3%; max-height:300px; overflow-y: auto">
            <table class="table table-sm table-stripped">
                <thead>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>#</th>
                </thead>
                <tbody>
                    <?php
                        mysqli_select_db($link, "usuario");
                        $sql = "SELECT * FROM usuario WHERE namespace = '$_SESSION[namespace]'";
                        $query = mysqli_query($link, $sql);
                        while($row = mysqli_fetch_array($query)){
                             ?>
                             <tr>
                                 <td> <?php echo $row['nome'] ?></td>
                                 <td> <?php echo $row['login'] ?></td>
                                 <td> <?php echo $row['email'] ?></td>
                                 <td> <a onclick="editar(<?php echo $row['id'] ?>, '<?php echo $row['nome'] ?>', '<?php echo $row['email'] ?>', '<?php echo $row['login'] ?>', '<?php echo $row['senha'] ?>', '<?php echo $row['data_nascimento'] ?>')"> <i class="far fa-edit"></i></a> </td>
                             </tr>
                             <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php
    mysqli_select_db($link, "usuario");
    $libera = false;
    @$id = $_POST['idUsuario'];
    @$nome = $_POST['nome'];
    @$email = $_POST['email'];
    @$datanascimento = $_POST['datanascimento'];
    @$login = $_POST['login'];
    @$senha = $_POST['senha'];

    $diretorio = $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/modulos/usuario/imagens/';

    @$foto = basename($_FILES['fotoperfil']['name']);
    if($id!=''){
        if($foto == ''){
            $sql = "UPDATE usuario SET nome = '$nome', email = '$email', login = '$login', data_nascimento = '$datanascimento' WHERE id = $id";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            if($query){
                echo "<script>alert('Salvo com sucesso'); window.location.href = '/owlsoftware/modulos/index.php?pag=usuario'; </script>";
            }else{
                echo "<script>alert('Erro ao salvar usuário.".mysqli_error($link)."'); </script>";
            } 
        }else{
            if(move_uploaded_file($_FILES['fotoperfil']['tmp_name'], $diretorio.$foto)){
                $sql = "UPDATE usuario SET nome = '$nome', email = '$email', login = '$login', data_nascimento = '$datanascimento', foto = '$foto' WHERE id = $id";
                $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                if($query){
                    echo "<script>alert('Salvo com sucesso'); window.location.href = '/owlsoftware/modulos/index.php?pag=usuario'; </script>";
                }else{
                    echo "<script>alert('Erro ao salvar usuário.".mysqli_error($link)."'); </script>";
                }   
            }else{
                echo "<script>alert('Erro ao salvar usuário.". mysqli_error($link) ."'); </script>";
            }
        }
    }else{
        if($foto !=''){
            if(move_uploaded_file($_FILES['fotoperfil']['tmp_name'], $diretorio.$foto)){
                $sql = "SELECT * FROM usuario WHERE login =' $login'";
                $query = mysqli_query($link, $sql);
                if(mysqli_num_rows($query)>0){
                    echo "<script>alert('Erro ao salvar usuário, login informado já cadastrado.'); </script>";
                }else{
                    $sql = "INSERT INTO usuario(nome, email, data_nascimento, login, senha,  foto, namespace) VALUES('$nome', '$email', '$datanascimento', '$login', '$senha', '$foto', (SELECT id FROM namespace HWERE namespace = '$_SESSION[namespace]'))";
                    $query = mysqli_query($link, $sql);
                    if($query){
                        $libera = true;
                    }else{
                        echo "<script>alert('Erro ao salvar usuário.". mysqli_error($link) ."'); </script>";
                    }
                }
    
            }else{  
                echo "<script>alert('Erro ao salvar usuário.'); </script>";
            }
        }else{
            if($nome != '' && $email != '' && $datanascimento != '' && $login != '' && $senha != ''){
                $sql = "SELECT * FROM usuario WHERE login = '$login'";
                $query = mysqli_query($link, $sql);
                if(mysqli_num_rows($query)>0){
                    echo "<script>alert('Erro ao salvar usuário, login informado já cadastrado.'); </script>";
                }else{
                    $sql = "SELECT MAX(id)+1 FROM usuario";
                    $query = mysqli_query($link,$sql);
                    $linha = mysqli_fetch_row($query);
                    $id = $linha[0];
                    $sql = "INSERT INTO usuario(id, nome, email, data_nascimento, login, senha, namespace) VALUES($id,'$nome', '$email', '$datanascimento', '$login', '$senha', '$_SESSION[namespace]')";
                    $query = mysqli_query($link, $sql) or die(mysqli_error($link));
                    if($query){
                        $libera = true;
                    }else{
                        echo "<script>alert('Erro ao salvar usuário. ". mysqli_error($link) ."'); </script>";
                    }
                }
    
            }
     
        }
    
        if($libera){
            liberaTodosS($id, $link);
            echo "<script>alert('Salvo com sucesso'); window.location.href = '/owlsoftware/modulos/index.php?pag=usuario'; </script>";
        }
    }
        
    
    
?>
</html>