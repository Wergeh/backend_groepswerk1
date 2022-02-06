<?php

require_once "lib/autoload.php";
$query = 'select c.name as Category, sex as Sex, s.name as Discipline, concat_ws(" ",record,meeteenheid) as Record,
                        concat_ws(" ",`first name`, `last name`) as Athlete, nationaliteit as Nationality, date as Date,
                        plaats as Venue
                    from record
                        inner join meeteenheid m on record.`FK.meeteenheidID` = m.meeteenheidID
                        inner join plaats p on record.`FK.plaatsID` = p.plaatsID
                        inner join atleet a on record.`FK.atleetID` = a.atleetID
                        inner join nationaliteit n on a.`FK.nationaliteitID` = n.nationaliteitID
                        inner join sports s on record.`FK.sportsID` = s.id
                        inner join cat c on s.cat_id = c.id ';
$extra="";
$name="";
if (key_exists("search",$_GET)){
    $name=$_GET["search"];
    unset($_GET["search"]);
    $extra='having Athlete like "%'.$name.'%"';
}
$category="";
if (key_exists("filter",$_GET)){
    $category=$_GET["filter"];
    unset($_GET["filter"]);
    $extra='having Category like "%'.$category.'%"';
}
$data = GetData($query.$extra);
var_dump($data);
?>
<form method="get" action="">
    <input type="text" name="search">
</form>
<div>
    <?php
    $dataCat='group by c.name';
    $cat= GetData($query.$dataCat);
    foreach ($cat as $c){
        print '<a href="?filter='.$c["Category"].'">'.$c["Category"].'</a>';
    }
    ?>
</div>
