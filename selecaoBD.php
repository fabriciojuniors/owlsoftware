<?php
    session_start();
    function selectBD($link){
        mysqli_select_db($link, $_SESSION['namespace']);
    }

?>