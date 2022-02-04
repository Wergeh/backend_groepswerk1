<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintNavbar();
?>
<body>
<div class="container">
    <div class="row">

        <?php

        date_default_timezone_set("Europe/Brussels");
        setlocale(LC_TIME, 'nl_NL');

        $now = new DateTime('NOW', new DateTimeZone('Europe/Brussels'));
        $start = $now->modify('monday this week');

        $now = new DateTime('NOW', new DateTimeZone('Europe/Brussels'));
        $now = $now->modify('monday this week');
        $end = $now->modify('+6 days');

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

//        "' . $start->format('Y-m-d') . '" and "' .$end->format('Y-m-d').'"'

        $data = GetData($query);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

        // loop over alle dagen van deze week & print voor elke dag een table row
        // per dag loop over uw opgevraagde data / in deze loop checken of taa_datum === datum van de dag (if) als dit true is in je laatse td row je omschrijving printen met uur
        
        ?>

        <table class="table table-striped table-dark">
            <tbody>
            <?php foreach ($period as $day) : ?>
                <tr>
                    <td><?php echo $day->format('l'); ?></td>
                    <td><?php echo $day->format('Y-m-d'); ?></td>
                    <td><?php foreach ($data as $taak){
                        if ($taak['taa_datum'] === $day->format('Y-m-d')){
                            $startTime = new DateTime($taak['taa_start']);
                            $startTime = $startTime->format('H:i');
                            $endTime = new DateTime($taak['taa_end']);
                            $endTime = $endTime->format('H:i');
                            echo $startTime. ' - '. $endTime.' '. $taak['taa_omschr']. '<br>';
                        }
                        } ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>