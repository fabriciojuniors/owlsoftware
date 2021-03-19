<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM banco WHERE inativo = 0";
    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    if(mysqli_num_rows($query) >= 1){
        while($row = mysqli_fetch_array($query)){
            $bancos[] = array(
                "id" => $row['id'],
                "nome" => $row['nome']
            );
        }
        $bancosJson = json_encode($bancos);
        echo $bancosJson;
    }else{
        echo "Erro";
    }
?>

