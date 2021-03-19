<?php
    include_once "selecaoBD.php";
    $link = mysqli_connect("xlf3ljx3beaucz9x.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "iv6mo0axy4pavmon", "pazsmcxlvyr27qkm");

    if(isset($_SESSION['namespace'])){
        selectBD($link);
    }
    // if($link){
    //     echo "Sucesso";
    // } else{
    //     echo "Erro ao conectar banco de dados";
    // }

?>
