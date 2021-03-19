<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/owlsoftware/selecaoBD.php";
    $link = mysqli_connect("localhost", "root", "");

    if(isset($_SESSION['namespace'])){
        selectBD($link);
    }
    // if($link){
    //     echo "Sucesso";
    // } else{
    //     echo "Erro ao conectar banco de dados";
    // }

?>
