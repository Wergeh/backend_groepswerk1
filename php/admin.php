<?php
require_once "lib/autoload.php";
$query = 'select concat_ws(" ",first_name, last_name) as Athlete
                    from atleet';

$data = GetData($query);

if (key_exists("Athlete",$_GET)){
    $query2='select atleetID, concat_ws(" ",first_name, last_name) as Athlete
from atleet
having Athlete like "'.$_GET["Athlete"].'"';
    $data2=GetData($query2);
    var_dump($data2);
}

$html= "
    <form method='GET'>
    <input list='Athlete' name='Athlete'>
    <datalist id='Athlete'>
    ";
foreach ($data as $row){
    $html.="<option value='{$row["Athlete"]}'>";
}
$html.= "</datalist> <input type='submit'></form>";

print $html;