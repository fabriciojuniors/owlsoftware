<?php
    include_once "conexao.php";
    unset($_SESSION['usuario']);
    unset($_SESSION['foto']);
    unset($_SESSION['id']);
    unset($_SESSION['namespace']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="common/css/bootstrap.min.css">
  <link rel="stylesheet" href="common/css/estilo.css">
  <!-- <script src="common/js/jquery.min.js"></script> -->
  <!-- <script src="/owlsoftware/autentica.js"></script> -->

  <title>OwlSoftware - Login</title>

  <!-- Custom fonts for this template-->
  <link href="menu/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="menu/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body  style="background-color: rgba(1, 1, 7, 0.89);">

  <div class="container">
    <div style="height: 75px;">

    </div>
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bem vindo</h1>
                  </div>
                  <form method="POST" action="" class="user">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" required id="login" name="login" aria-describedby="emailHelp" placeholder="Informe o seu usuário">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" required id="senha" name="senha" placeholder="Informe sua senha">
                    </div>
                    <button id="entrar" type="submit" class="btn btn-primary btn-user btn-block">
                      Entrar
                    </button>
                    <hr>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="menu/vendor/jquery/jquery.min.js"></script>
  <script src="menu/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="menu/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="menu/js/sb-admin-2.min.js"></script>
</body>
</html>

<?php
    if(isset($_POST['login']) && isset($_POST['senha'])){
        mysqli_select_db($link, 'usuario');
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha'";
        $query = mysqli_query($link, $sql);

        if(mysqli_num_rows($query)>0){
           $result =  mysqli_fetch_array($query);
           if($result['namespace'] === "" || $result['namespace'] === null){
            $_SESSION['usuario'] = $result['nome'];
            $_SESSION['foto'] = $result['foto'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['multiplos'] = "s";
            header("Location: /owlsoftware/modulos/selecaoNamespace.php") ;
           }else{
            $_SESSION['usuario'] = $result['nome'];
            $_SESSION['foto'] = $result['foto'];
            $_SESSION['id'] = $result['id'];
            $_SESSION['namespace'] = $result['namespace'];
            $_SESSION['multiplos'] = "n";
            header("Location: /owlsoftware/modulos/index.php") ;
           }

        }else{
            echo "<script> alert('Usuário ou senha inválidos.'); </script>";
        }
    }
?>
