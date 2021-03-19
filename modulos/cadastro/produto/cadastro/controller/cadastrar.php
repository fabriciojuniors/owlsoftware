<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['id'] == ''){
        cadastrar($link, $dados);
    }else{
        atualizar($link, $dados);
    }

    function cadastrar($link, $dados){
        if($dados['cod'] != ''){
            $cod = $dados['cod'];
            $sql = "SELECT * FROM produto WHERE cod = '$cod'";
            $query = mysqli_query($link, $sql);
            $row = mysqli_num_rows($query);
            if($row != 0){
                echo "Código informado já utilizado.";
            }else{
                salvar($link, $dados, $cod);
            }
        }else{
            $sql = "SELECT max(CAST(cod as int)) FROM produto";
            $query = mysqli_query($link,$sql);
            $resultado = mysqli_fetch_array($query);
            $cod =  $resultado[0]+1;
            salvar($link, $dados, $cod);
        }
    }
    function salvar($link, $dados, $cod){
        $data = date("Y-m-d");
        $sql = "INSERT INTO `produto` (`id`, `cod`, `descricao`, `referencia`, `tipo_produto`, `grupo_produto`, `marca`, `cor`,  `preco_max`, `preco_min`, `dt_criacao`, `dt_alteracao`, `foto`, `inativo`, `usuario_atualizacao`, `usuario_criacao`) VALUES (null, '$cod', '$dados[descricao]', '$dados[referencia]', $dados[tprod], '$dados[gprod]', '$dados[marca]', '$dados[cor]',  '$dados[preco_maximo]', '$dados[preco_minimo]', '$data', '$data','', '$dados[inativo]',  '$dados[usuario]', '$dados[usuario]')";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));
        
        if($query){
             $sql = "SELECT max(id)FROM produto";
             $query = mysqli_query($link, $sql);
             $resultado = mysqli_fetch_array($query);
             $id = $resultado[0];
             $sql = "SELECT cod FROM produto WHERE id = $id";
             $query = mysqli_query($link, $sql);
             $resultado = mysqli_fetch_array($query);
             $cod = $resultado[0];

             $resultado = array(
                 "id" => $id,
                 "cod" => $cod
             );
             $resultadoJson = json_encode($resultado);
             echo $resultadoJson;
            
        }else{
            echo "Erro";
        }
        
    }
        function atualizar($link, $dados){
            $data =date("Y-m-d");
            $sql = "UPDATE produto SET cod = '$dados[cod]', descricao = '$dados[descricao]', referencia = '$dados[referencia]', tipo_produto = $dados[tprod], grupo_produto = $dados[gprod], marca = $dados[marca], cor = '$dados[cor]', preco_max = '$dados[preco_maximo]', preco_min = '$dados[preco_minimo]', inativo = $dados[inativo], usuario_atualizacao = '$dados[usuario]', dt_alteracao = '$data' WHERE id = $dados[id]";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            if($query){
                echo "Atualizou";
            }else{
                echo "Erro" . mysqli_error($link);
            }
        };
?>