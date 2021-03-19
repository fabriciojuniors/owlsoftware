<?php
/**
 * @author Cesar Szpak - Celke - cesar@celke.com.br
 * @pagina desenvolvida usando FullCalendar e Bootstrap 4,
 * o código é aberto e o uso é free,
 * porém lembre-se de conceder os créditos ao desenvolvedor.
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';

$query_events = "SELECT id, title, color, start, end FROM agendamentos";
$query = mysqli_query($link, $query_events) or die(mysqli_error($link));

$eventos = [];

while($row_events = mysqli_fetch_array($query)){
    $id = $row_events['id'];
    $title = $row_events['title'];
    $color = $row_events['color'];
    $start = $row_events['start'];
    $end = $row_events['end'];
    
    $eventos[] = [
        'id' => $id, 
        'title' => $title, 
        'color' => $color, 
        'start' => $start, 
        'end' => $end, 
        ];
}

echo json_encode($eventos);