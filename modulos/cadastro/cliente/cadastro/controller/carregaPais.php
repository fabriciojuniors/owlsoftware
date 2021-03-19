<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM pais";
    $query = mysqli_query($link, $sql);

    if($query){
        while($row = mysqli_fetch_array($query)){
            $tps[] = array(
                "id" => $row['id'],
                "cod" => $row['cod'],
                "descricao" => $row['nome'],
                "inativo" => $row['inativo']
            );
        }
        $tpsJson = json_encode($tps);
        echo $tpsJson;
    }else{
        echo "Erro ao carregar informação.";
    }
?>