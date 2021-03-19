<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    if($dados['codigo'] == ''){
        $sql = "INSERT INTO tabela_preco(descricao, max_desconto, criacao, atualizacao, usuario_criacao, usuario_atualizacao) VALUES ('$dados[descricao]', $dados[max_desconto], '$dados[criacao]', '$dados[criacao]', $_SESSION[id], $_SESSION[id])";
        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        if($query){
            $sql = "SELECT MAX(codigo) FROM tabela_preco";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            if($query){
                $row = mysqli_fetch_array($query);
                $codigo = $row[0];

                echo $codigo;
            }
        } else{
            echo "Erro ao salvar tabela de preço. \n" . mysqli_error($link);
        }
    }
?>