<?php
    //session_start();
    include_once "../conexao.php";
    include "../modulos/usuario/liberaTodos.php";
    require '../vendor/autoload.php';

    if(!isset($_SESSION['usuario'])){
      echo "<script>
      alert('Você precisa estar conectado para acessar o sistema.  Redirecionando à tela de login.');
      window.location.href = '/owlsoftware/';
      </script>";
    }
    if($_SESSION['multiplos'] == "s"){
        liberaTodos($_SESSION['id'], $link);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="../menu/vendor/fontawesome-free/css/all.css">
  <!-- <link href="/owlsoftware/menu/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css"> -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
  <!-- Custom styles for this template-->
  <link href="../menu/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="../common/js/jquery.min.js"></script>

</head>
<style>
      .load {
        position: absolute;
        left: 60%;
        top: 50%;
        z-index: 1;
        width: 100px;
        height: 100px;
        margin: -100px 0 0 -100px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid black;
        width: 90px;
        height: 90px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
      }

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

#collapseTwo::-webkit-scrollbar-track
{
	box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#collapseTwo::-webkit-scrollbar
{
	width: 2px;
	background-color: #F5F5F5;
}

#collapseTwo::-webkit-scrollbar-thumb
{
	background-color: #4d4a44;
}

</style>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav toggled sidebar sidebar-dark accordion" style="background-color: black; height: auto;" id="accordionSidebar">
    <!-- rgba(1, 1, 7, 0.89) -->
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <!-- <i class="fas fa-laugh-wink"> </i> -->
          <i class="">
            <img src="../image/coruja.png" width="30px" height="30px" alt="">
          </i>
        </div>
        <div class="sidebar-brand-text mx-3">OwlSoftware</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="?pag=dashboard">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseAgendamento" aria-expanded="true" aria-controls="collapseEstoque">
          <i class="fas fa-address-book"></i>
          <span>Agendamento</span>
        </a>
        
         <div id="collapseAgendamento" class="collapse" aria-labelledby="headingEstoque" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" target="_blank" href="?pag=agendamento" id="agendamento">Agendamento</a>
          </div> 
        </div>
      </li>
      

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-database"></i>
          <span>Cadastros</span>
        </a>
        <div id="collapseTwo" style="max-height: 450px; overflow-y: auto;" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item"  target="_blank" id="cidade" href="?pag=cidade">Cidade</a>
            <a class="collapse-item"  target="_blank" id="cliente" href="?pag=cliente">Cliente / Fornecedor</a>
            <a class="collapse-item" target="_blank" id="condpag" href="?pag=condpag">Condicação de Pagto.</a>
            <a class="collapse-item" target="_blank" id="contabancaria" href="?pag=contabancaria">Conta Bancária</a>
            <a class="collapse-item" target="_blank" id="UF" href="?pag=UF">Estado/UF</a>
            <a class="collapse-item" target="_blank" id="forma_pagamento" href="?pag=forma_pagamento">Forma de Pagamento</a>
            <a class="collapse-item" target="_blank" id="grupo_produto" href="?pag=grupo_produto">Grupo de Produto</a>
            <a class="collapse-item" target="_blank" id="marca" href="?pag=marca">Marca</a>
            <a class="collapse-item" target="_blank" id="origem_estoque" href="?pag=origem_estoque">Origem Movto. Estoque</a>
            <a class="collapse-item" target="_blank" id="pais" href="?pag=pais">País</a>
            <a class="collapse-item" target="_blank" id="banco" href="?pag=banco">Portador</a>
            <a class="collapse-item" target="_blank" id="produto" href="?pag=produto">Produto</a>
            <a class="collapse-item" target="_blank" id="tabela_preco" href="?pag=tabela_preco">Tabela de Preço</a>
            <a class="collapse-item" target="_blank" id="tamanho" href="?pag=tamanho">Tamanho</a>
            <a class="collapse-item" target="_blank" id="movto_estoque" href="?pag=movto_estoque">Tipo de Movto. Estoque</a>
            <a class="collapse-item" target="_blank" id="movto_financeiro" href="?pag=movto_financeiro">Tipo de Movto. Financeiro</a>
            <a class="collapse-item" target="_blank" id="tipo_produto" href="?pag=tipo_produto">Tipo de Produto</a>
            <a class="collapse-item" target="_blank" id="tipo_venda" href="?pag=tipo_venda">Tipo de Venda</a>
            <a class="collapse-item" target="_blank" id="tipo_entrada" href="?pag=tipo_entrada">Tipo de Entrada</a>
          </div>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="#"  data-toggle="collapse" data-target="#collapseEstoque" aria-expanded="true" aria-controls="collapseEstoque">
          <i class="fas fa-cubes"></i>
          <span>Estoque</span>
        </a>
        <div id="collapseEstoque" class="collapse" aria-labelledby="headingEstoque" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastro
              </a>
              <div class="dropdown-menu">
                <a class="collapse-item" target="_blank" id="ajuste" href="?pag=ajuste">Ajuste</a>
                <a class="collapse-item" target="_blank" id="entrada_xml" href="?pag=entrada_xml">Nota Fiscal de Entrada com XML</a>
              </div>

            </div>
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Consulta
              </a>
              <div class="dropdown-menu">
                <a class="collapse-item" target="_blank" id="kardex" href="?pag=kardex">Kardex</a>
              </div>
            </div>
            
            
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinanceiro" aria-expanded="true" aria-controls="collapseFinanceiro">
          <i class="fas fa-money-bill-alt"></i>
          <span>Financeiro</span>
        </a>
        <div id="collapseFinanceiro" class="collapse" aria-labelledby="headingFinanceiro" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Caixa
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" id="movban" href="?pag=movban">Movimentações bancárias</a>
                <!-- <div class="dropdown-divider"></div>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=OR">Ordem de Recebimento</a> -->
              </div>
            </div>
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Contas a Receber
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Cadastro</div>
                <a class="collapse-item" target="_blank" id="OR" href="?pag=OR">Ordem de Recebimento</a>
                <a class="collapse-item" target="_blank" id="liquidacao_or" href="?pag=liquidacao_or">Liquidação</a>
                <!-- <div class="dropdown-divider"></div>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=OR">Ordem de Recebimento</a> -->
              </div>
            </div>
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Contas a Pagar
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Cadastro</div>
                <a class="collapse-item" target="_blank" id="OP" href="?pag=OP">Ordem de Pagamento</a>
                <a class="collapse-item" target="_blank" id="liquidacao_op" href="?pag=liquidacao_op">Liquidação</a>
                <!-- <div class="dropdown-divider"></div>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=OR">Ordem de Recebimento</a> -->
              </div>
            </div>
            
            
          </div>
          
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVendas" aria-expanded="true" aria-controls="collapseVendas">
        <i class="fas fa-cart-plus"></i>
          <span>Vendas</span>
        </a>
        <div id="collapseVendas" class="collapse" aria-labelledby="headingVendas" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Pedido
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Cadastro</div>
                <a class="collapse-item" target="_blank" id="pedido" href="?pag=pedido">Pedido</a>
                <!-- <div class="dropdown-divider"></div>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=OR">Ordem de Recebimento</a> -->
              </div>
            </div>     
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Faturamento
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Cadastro</div>
                <a class="collapse-item" target="_blank" id="nf_pedido" href="?pag=nf_pedido">Nota Fiscal</a>
                <a class="collapse-item" target="_blank" id="cancelar_venda" href="?pag=cancelar_venda">Cancelar Nota Fiscal</a>
                <a class="collapse-item" target="_blank" id="nf_devolucao" href="?pag=nf_devolucao">Devolução</a>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=consulta_nf_pedido"> Nota Fiscal</a> 
              </div>
            </div>    
            <div class="dropright">
              <a type="button" id="submenu1" class="dropdown-toggle collapse-item" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-align: right;">
                Relatórios
              </a>
              <div class="dropdown-menu">
                <div class="dropdown-header">Relatório</div>
                <a class="collapse-item" target="_blank" id="rel_nf_emitidas" href="?pag=rel_nf_emitidas">NF Emitidas</a>
                <a class="collapse-item" target="_blank" id="rel_nf_canceladas" href="?pag=rel_nf_canceladas">NF Canceladas</a>
                <!-- <div class="dropdown-divider"></div>
                <div class="dropdown-header">Consulta</div>
                <a class="collapse-item" target="_blank" href="?pag=OR">Ordem de Recebimento</a> -->
              </div>
            </div>  
          </div>       
        </div>
        
      </li>
      

      <!-- Nav Item - Utilities Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-shopping-cart"></i>
          <span>Vendas</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" target="_blank" href="?pag=pedido">Pedido</a>
          </div>
        </div>
      </li> -->
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" onchange="buscarTela()" placeholder="Pesquisar" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="nome_usuario"><script>document.getElementById("nome_usuario").innerHTML = "<?php echo $_SESSION['usuario'];?>"</script></span>
                <!-- <img class="img-profile rounded-circle" src="/owlsoftware/menu/img/"> -->
                <script>
                  if(localStorage.getItem("foto") != ''){
                    var img = document.createElement('img');
                    var caminho = "<?php echo ($_SESSION['foto'] == '') ? "/owlsoftware/menu/img/usuario.png" : "/owlsoftware/modulos/usuario/imagens/$_SESSION[foto]"?>";
                    console.log(caminho);
                    img.src = caminho;
                    img.classList.add("img-profile");
                    img.classList.add("rounded-circle");
                    document.getElementById("userDropdown").appendChild(img);
                  }

                </script>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" id="usuario" href="?pag=usuario">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Usuario
                </a>
                <a class="dropdown-item" href="?pag=parametros">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Parâmetros do sistema
                </a>
                <a class="dropdown-item" href="?pag=permissoes">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Permissões de acesso
                </a>
                <a class="dropdown-item" href="?pag=empresa">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Empresa de trabalho
                </a>
                <a class="dropdown-item" href="?pag=integracao">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Integração ERP
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Sair
                </a>
              </div>
            </li>
          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div id="loader" style="display: block;" class="load"></div>
        <div style="display: none;" class="container-fluid" id="conteudo-aqui">
          <?php
            if(isset($_GET['pag'])){
              $pag = $_GET['pag'];
              $sql = "SELECT telas.caminho
                      FROM telas INNER JOIN permissoes_acesso
                      WHERE telas.id = permissoes_acesso.tela
                            AND permissoes_acesso.usuario = $_SESSION[id]
                            AND permissoes_acesso.liberado = 1
                            AND telas.nome = '$pag'";
              $query = mysqli_query($link, $sql) or die(mysqli_error($link));
              
              if($query){
                if(mysqli_num_rows($query)>0){
                  $tela = mysqli_fetch_array($query);
                  include_once($_SERVER['DOCUMENT_ROOT'].$tela[0]);
                }else{
                  echo "<strong>Atenção:</strong>A tela requisitada não está disponível para o seu usuário, entre em contato com o responsável pelo sistema para maiores informações.";
                }
              }else{
                echo mysqli_error($link);
              }
              
            }else{
              include_once($_SERVER['DOCUMENT_ROOT']."/owlsoftware/modulos/dashboard.html");
            }
          ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; OwlSoftware 2020</span>
          </div>
        </div>
      </footer> -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deseja realmente sair:</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Clique em "Sair" para finalizar a sessão atual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary btn-square" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary btn-square" href="../index.php">Sair</a>
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

  <!-- Page level plugins -->
  <!-- <script src="/owlsoftware/menu/vendor/chart.js/Chart.min.js"></script> -->

  <!-- Page level custom scripts -->
  <!-- <script src="/owlsoftware/menu/js/demo/chart-area-demo.js"></script> -->
  <!-- <script src="/owlsoftware/menu/js/demo/chart-pie-demo.js"></script> -->

</body>
<script>
    $(window).on('load', loader());
    function loader(){
      document.getElementById("conteudo-aqui").style.display = "block";
      document.getElementById("loader").style.display = "none";
      
    }
    var dados = {usuario: <?php echo $_SESSION['id'];?>};
    fetch("../modulos/adm/permissoes/controller/validaacesso.php",{
      method: "POST"  ,
      body: JSON.stringify(dados),
      headers: {'Content-Type': 'application/json'}
    }).then(function(response){
        return response.text();
    }).then(function(text){
       var permissoes = JSON.parse(text);
         permissoes.forEach(p => {
             if(p[1] == 0){
                 document.getElementById(p[0]).style.display = 'none';
             }
         });
    }).catch(function(error){
        console.log(error);
    });
</script>
</html>
