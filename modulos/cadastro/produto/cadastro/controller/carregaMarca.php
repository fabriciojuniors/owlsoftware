<?php
    include $_SERVER['DOCUMENT_ROOT']."/owlsoftware/conexao.php";

    $sql = "SELECT * FROM marca";
    $query = mysqli_query($link, $sql);

    if($query){
        while($row = mysqli_fetch_array($query)){
            $marcas[] = array(
                "id" => $row['id'],
                "cod" => $row['cod'],
                "descricao" => $row['descricao'],
                "inativo" => $row['inativo']
            );
        }
        $marcasJson = json_encode($marcas);
        echo $marcasJson;
    }else{
        echo "Erro ao carregar informação.";
    }
?>