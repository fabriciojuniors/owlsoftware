<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);

    $sqlProduto = "SELECT id FROM produto WHERE cod = '$dados[produto]'";
    $queryProduto = mysqli_query($link, $sqlProduto);
    $rowProduto = mysqli_fetch_array($queryProduto);
    $idProduto = $rowProduto[0];

    if($dados['custo'] == '' || $dados['quantidade'] == '' || $dados['tamanho'] == '#'){
        echo 'Erro ao salvar estoque do produto. Para continuar, informe quantidade, custo e tamanho';
    }
    else if($dados['tpmovto'] == '#'){
        echo 'Erro ao salvar estoque do produto. Para continuar, informe o tipo de movimento.';
    }
    else{
        $sql = "INSERT INTO item_ajuste(id_ajuste, tp_movto_estoque, produto, quantidade, custo, tamanho) VALUES ('$dados[ajuste]', '$dados[tpmovto]', '$idProduto', '$dados[quantidade]', '$dados[custo]', '$dados[tamanho]')";
        $query = mysqli_query($link, $sql);
        if($query){
            $sql = "INSERT INTO movimento_estoque(produto, origem_estoque, tp_movto_estoque, quantidade, valor, num_doc, data) VALUES($idProduto, 1, $dados[tpmovto], $dados[quantidade], $dados[custo], $dados[ajuste], (SELECT data FROM ajuste WHERE id = $dados[ajuste]))";
            $query = mysqli_query($link, $sql) or die(mysqli_error($link));
            if($query){
                echo "Salvo";
            }else{
                echo "Erro ao salvar movimentação. \n" . mysqli_error($link);
            }
            
        }else{
            echo "Erro ao salvar movimentação de estoque. \n ". mysqli_error($link);
        };
    }

?>