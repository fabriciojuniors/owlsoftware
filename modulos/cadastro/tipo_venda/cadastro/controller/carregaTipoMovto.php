<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM tp_movto_estoque WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) >= 1){
        while($row = mysqli_fetch_array($query)){
            $origem[] = array(
                "id" => $row['id'],
                "descricao" => $row['descricao']
            );
        }
        $origemJson = json_encode($origem);
        echo $origemJson;
    }else{
        echo "Erro";
    }
?>

