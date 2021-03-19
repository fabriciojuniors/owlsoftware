<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
    $data = date("Y-m-d");
    if($dados['codigo'] == ''){
        $sql = "SELECT IFNULL((MAX(codigo)+1),1)  FROM tp_entrada";
        $query = mysqli_query($link, $sql);
        if(mysqli_num_rows($query)>0){
            $linha = mysqli_fetch_array($query);
            $cod = $linha[0];
            $sql = "INSERT INTO tp_entrada(codigo, descricao, gerar_financeiro, dt_criacao, dt_atualizacao, usuario_criacao, usuario_atualizacao, inativo, origem_estoque) 
                    VALUES($cod, '$dados[descricao]', $dados[geraFinanceiro], '$data', '$data', $_SESSION[id], $_SESSION[id], $dados[inativo], $dados[origem])";
            $query = mysqli_query($link, $sql);
            if($query){
                echo "Salvo com sucesso.";
            }else{
                echo "Erro ao salvar tipo de operação de entrada. \n". mysqli_error($link);
            }
        }
            
    }else{
        $sql = "UPDATE tp_entrada SET origem_estoque = $dados[origem], descricao = '$dados[descricao]', gerar_financeiro = $dados[geraFinanceiro], inativo = $dados[inativo], usuario_atualizacao = $_SESSION[id], 
                dt_atualizacao = '$data' WHERE codigo = $dados[codigo]";
        $query = mysqli_query($link, $sql);
        if($query){
            echo "Salvo com sucesso.";
        }else{
            echo "Erro ao salvar tipo de operação de entrada. \n". mysqli_error($link);
        }                
    }

?>