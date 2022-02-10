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

        //Default query
        $query = 'select concat_ws(" ",first_name, last_name) as Athlete, atleetID as ID, nationaliteit as Nationality
                    from atleet
                    inner join nationaliteit n on atleet.`FK.nationaliteitID` = n.nationaliteitID';

        //Init extra
        $extra="";
        //Init name
        $name="";
        //Init category
        $category="";
        //Check if search param exists
        if (key_exists("search",$_GET)){
            $name = $_GET["search"];
            $extra = $extra . ' having Athlete like "%' . $name . '%"';
        }
        //Check if filter param exists
        if (key_exists("filter",$_GET)){
            $category = $_GET["filter"];
            if (isset($_GET["search"])){
                $extra = $extra . ' and Category like "%' . $category . '%"';
            } else {
                $extra = $extra . ' having Category like "%' . $category . '%"';
            }
        }
        //Execute query
        $data = GetData($query.$extra);

        ?>

        <table class="table table-striped table-dark">
            <thead>
            <tr class="font-weight-bold">
                <td>Athlete</td>
                <td>Nationality</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($data as $row) : ?>
                <tr>
                    <td><a class="text-white" href="<?php echo 'athlete.php?id=' . $row['ID'] ?>"><?php echo $row['Athlete']?></a></td>
                    <td><?php echo $row['Nationality']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>