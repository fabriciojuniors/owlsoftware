<?php
    include_once "../conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="/owlsoftware/common/css/bootstrap.min.css">
  <link rel="stylesheet" href="/owlsoftware/common/css/estilo.css">
  <!-- <script src="common/js/jquery.min.js"></script> -->
  <!-- <script src="/owlsoftware/autentica.js"></script> -->
  <script>
    window.onload = function(e){
      localStorage.clear();
    }
  </script>

  <title>OwlSoftware - Login</title>

  <!-- Custom fonts for this template-->
  <link href="/owlsoftware/menu/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/owlsoftware/menu/css/sb-admin-2.min.css" rel="stylesheet">

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
                      <select class="form-control" name="namespace" id="namespace">
                        <option value="#">Selecione</option>
                        <?php
                            mysqli_select_db($link, "usuario");
                            $query = mysqli_query($link, "SELECT DATABASE()");
                            $result = mysqli_fetch_row($query);
                            echo $result[0];
                            $sql = "SELECT * FROM namespace";
                            $query = mysqli_query($link, $sql) or die(mysqli_error($query));
                            if(mysqli_num_rows($query)>0){
                                while($row = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $row['namespace'];?>"><?php echo $row['namespace'];?> (Expira em: <?php echo date("d/m/Y", strtotime($row['data_expiracao']));?>)</option>
                                    <?php
                                }
                            }
                        ?>
                      </select>
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
  <script src="/owlsoftware/menu/vendor/jquery/jquery.min.js"></script>
  <script src="/owlsoftware/menu/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/owlsoftware/menu/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/owlsoftware/menu/js/sb-admin-2.min.js"></script>
</body>
</html>

<?php
    if(isset($_POST['namespace'])){
        $sql = "SELECT data_expiracao FROM namespace WHERE namespace = '$_POST[namespace]'";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        $row = mysqli_fetch_row($query);
        $expiracao = $row[0];
        $hoje = date("Y-m-d");
        if(strtotime($expiracao) > strtotime($hoje)){
            $_SESSION['namespace'] = $_POST['namespace'];
            header("Location: /owlsoftware/modulos/") ;
        }else{
            echo "<script> alert('Namespace seleciona está expirado.'); </script>";
            
        }

    }
?>

