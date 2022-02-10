<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintNavbar();

$id = null;
if (isset($_GET['id'])){
    $id = $_GET['id'];
}

//404-Page if id = null
//if($id = null){
//    header("Location: https://example.com/myOtherPage.php");
//}

$queryRecords = 'select c.name as Category, sex as Sex, s.name as Discipline, concat_ws(" ",record,meeteenheid) as Record,
       concat_ws(" ",first_name, last_name) as Athlete, nationaliteit as Nationality, date as Date,
       plaats as Venue
    from record
        inner join meeteenheid m on record.`FK.meeteenheidID` = m.meeteenheidID
        inner join plaats p on record.`FK.plaatsID` = p.plaatsID
        inner join atleet a on record.`FK.atleetID` = a.atleetID
        inner join nationaliteit n on a.`FK.nationaliteitID` = n.nationaliteitID
        inner join sports s on record.`FK.sportsID` = s.id
        inner join cat c on s.cat_id = c.id
        where atleetID = ' . $id;

$dataRecords = GetData($queryRecords);

$queryAthlete = 'select concat_ws(" ",first_name, last_name) as Athlete, nationaliteit as Nationality
                    from atleet
                        inner join nationaliteit n on atleet.`FK.nationaliteitID` = n.nationaliteitID
                        where atleetID = ' . $id;

$dataAthlete =  GetData($queryAthlete);

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-white mb-5 d-inline-block"><?php echo $dataAthlete[0]['Athlete']?></h1>
                <table class="table table-striped table-dark">
                    <thead>
                    <tr class="font-weight-bold">
                        <td>Category</td>
                        <td>Discipline</td>
                        <td>Record</td>
                        <td>Date</td>
                        <td>Venue</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dataRecords as $row) : ?>
                        <tr>
                            <td><a class='text-white' href="world_records.php?filterO=<?php echo $row['Category']?>"><?php echo $row['Category']?></a></td>
                            <td><?php echo $row['Discipline']?></td>
                            <td><?php echo $row['Record']?></td>
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
