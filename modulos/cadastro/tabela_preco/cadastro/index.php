<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
    if(isset($_GET['id'])){
        $sql = "SELECT tabela_preco.*, usuario.usuario.nome FROM `tabela_preco`, usuario.usuario WHERE tabela_preco.usuario_criacao = usuario.usuario.id AND codigo = $_GET[id]";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_array($query);
        }else{
            echo "<script> window.location.href = '/owlsoftware/modulos/index.php?pag=tabela_preco' </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-beta.4/dist/css/coreui.min.css">
    <link rel="stylesheet" href="/owlsoftware/common/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/owlsoftware/modulos/cadastro/tabela_preco/cadastro/js/script.js"></script>
    <title>Tabela de Preço</title>
</head>
<style>
    input[type="date"]::-webkit-inner-spin-button {
        display: none;
        -webkit-appearance: none;
    }
</style>

<body>
    <div id="conteudo" style="display: block;">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Tabela de Preço</h1>

            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar com grupos de botões">
                <div class="btn-group mr-2" role="group" aria-label="Primeiro grupo">
                    <button type="button" id="confirmar" onclick="confirmar()"
                        class="btn btn-square btn-success">Confirmar</button>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Segundo grupo">
                    <button type="button" onclick="limpar()" class="btn btn-square btn-light"
                        style="border: 1px solid rgb(110, 107, 107);">Novo</button>
                </div>
                <div class="btn-group" role="group" aria-label="Terceiro grupo">
                    <button type="button" class="btn btn-primary btn-square"
                        onclick="pesquisarProd(1,6)">Pesquisar</button>
                </div>
            </div>
        </div>

        <!-- Conteúdo -->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Cadastro</a>
                <a class="nav-link" id="nav-produto-tab" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Produtos</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> <?php  include('cadastro.php'); ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-produto-tab"><?php include('produtos.php') ?></div>
        </div>
        <!-- Fim Conteúdo -->

</body>
<script>

</script>

</html>