<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintNavbar();


date_default_timezone_set("Europe/Brussels");
setlocale(LC_TIME, 'nl_NL');

//Default query
$query = 'select c.name as Category, sex as Sex, s.name as Discipline, concat_ws(" ",record,meeteenheid) as Record,
                        concat_ws(" ",first_name, last_name) as Athlete, nationaliteit as Nationality, date as Date,
                        plaats as Venue
                    from record
                        inner join meeteenheid m on record.`FK.meeteenheidID` = m.meeteenheidID
                        inner join plaats p on record.`FK.plaatsID` = p.plaatsID
                        inner join atleet a on record.`FK.atleetID` = a.atleetID
                        inner join nationaliteit n on a.`FK.nationaliteitID` = n.nationaliteitID
                        inner join sports s on record.`FK.sportsID` = s.id
                        inner join cat c on s.cat_id = c.id';

//Init extra
$extra = "";
//Init name
$name = "";
//Init category
$category = "";
//Check if search param exists
if (key_exists("search", $_GET)&&isset($_GET["search"])) {
    $name = $_GET["search"];
    $extra = $extra . ' having Athlete like "%' . $name . '%"';
}
//Check if filter param exists
if (key_exists("filterO", $_GET)) {
    $category = $_GET["filterO"];
    if (isset($_GET["search"])) {
        $extra = $extra . ' and Category like "' . $category . '"';
    } else {
        $extra = $extra . ' having Category like "' . $category . '"';
    }
}
//Check if filter param exists
if (key_exists("filterI", $_GET)) {
    $category = $_GET["filterI"];
    if (isset($_GET["search"])) {
        $extra = $extra . ' and Category like "' . $category . '"';
    } else {
        $extra = $extra . ' having Category like "' . $category . '"';
    }
}
//Execute query
$data = GetData($query . $extra);


?>
<body>
<div class="container">
    <div class="row">
        <div class="col">
        <form method="get" action="">
            <div class="form-group">
            <input class="form-control" type="text" name="search" placeholder="search an athlete">
            </div>
            <div class="form-group">
                <p>Outdoor</p>
            <?php
            $dataCat='select cat.name from cat inner join sports s on cat.id = s.cat_id where inoutDoor like "o" group by cat.name';
            $cat= GetData($dataCat);
            foreach ($cat as $c){
                print '<input class="form-control" id="'.$c["name"].'O" type="radio" value="'.$c["name"].'" name="filterO">
                <label class="btn btn-dark" for="'.$c["name"].'O">'.$c["name"].'</label>';
            }
            ?>
            </div>
            <div class="form-group">
                <p>Indoor</p>
                <?php
                $dataCat='select cat.name from cat inner join sports s on cat.id = s.cat_id where inoutDoor like "i" group by cat.name';
                $cat= GetData($dataCat);
                foreach ($cat as $c){
                    print '<input class="form-control" id="'.$c["name"].'I" type="radio" value="'.$c["name"].'" name="filterI">
                <label class="btn btn-dark" for="'.$c["name"].'I">'.$c["name"].'</label>';
                }
                ?>
            </div>
            <div class="form-group">
            <input class="btn btn-dark form-control" type="submit">
            </div>
        </form>
        </div>
        <div class="col-10">
        <table class="table table-striped table-dark">
            <thead>
            <tr class="font-weight-bold">
                <td>Category</td>
                <td>Sex</td>
                <td>Discipline</td>
                <td>Record</td>
                <td>Athlete</td>
                <td>Nationality</td>
                <td>Date</td>
                <td>Venue</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $row) : ?>
                <tr>
                    <td><?php echo $row['Category']?></td>
                    <td><?php echo $row['Sex']?></td>
                    <td><?php echo $row['Discipline']?></td>
                    <td><?php echo $row['Record']?></td>
                    <td><?php echo $row['Athlete']?></td>
                    <td><?php echo $row['Nationality']?></td>
                    <td><?php echo $row['Date']?></td>
                    <td><?php echo $row['Venue']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        </div>

    </div>
</div>

</body>
</html>