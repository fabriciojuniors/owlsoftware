<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM grupo_produto";
    $query = mysqli_query($link, $sql);

    if($query){
        while($row = mysqli_fetch_array($query)){
            $gps[] = array(
                "id" => $row['id'],
                "cod" => $row['cod'],
                "descricao" => $row['descricao'],
                "inativo" => $row['inativo']
            );
        }
        $gpsJson = json_encode($gps);
        echo $gpsJson;
    }else{
        echo "Erro ao carregar informação.";
    }
?>