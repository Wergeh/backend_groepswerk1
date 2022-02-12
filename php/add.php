<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintNavbar();
?>

<div class="container">
    <div class="row">

        <?php
        //get data
        if ( count($old_post) > 0 )
        {
            $data = [ 0 => [
                "record" => $old_post['record'],
                "FK_meeteenheidID" => $old_post['FK_meeteenheidID'],
                "worldrecords" => $old_post['worldrecords'],
                "FK_plaatsID" => $old_post['FK_plaatsID'],
                "date" => $old_post['date'],
                "FK_atleetID" => $old_post['FK_atleetID'],
                "FK_sportsID" => $old_post['FK_sportsID']
            ]
            ];
        }
        else $data = [ 0 => [ "record" => "", "FK_meeteenheidID" => "", "worldrecords" => "", "FK_plaatsID" => "", "date" => "", "FK_atleetID" => "", "FK_sportsID" => "" ]];
        $row=$data[0];

        //get template
        $output = file_get_contents("templates/record_form.html");

        //add extra elements
        $extra_elements['csrf_token'] = GenerateCSRF( "add.php"  );
        $extra_elements['select_meeteenheid'] = MakeSelect( $fkey = 'FK_meeteenheidID',
            $value = $row['FK_meeteenheidID'] ,
            $sql = "select meeteenheidID, meeteenheid from meeteenheid" );
        $extra_elements['select_plaats'] = MakeSelect( $fkey = 'FK_plaatsID',
            $value = $row['FK_plaatsID'] ,
            $sql = "select plaatsID, plaats from plaats" );
        $extra_elements['select_atleet'] = MakeSelect( $fkey = 'FK_atleetID',
            $value = $row['FK_atleetID'] ,
            $sql = 'select atleetID, concat_ws(" ",first_name, last_name) as Athlete from atleet' );
        $extra_elements['select_sports'] = MakeSelect( $fkey = 'FK_sportsID',
            $value = $row['FK_sportsID'] ,
            $sql = 'select sports.id, concat_ws(" ", sports.name,c.name, sports.inoutDoor) as sport from sports inner join cat c on sports.cat_id = c.id' );

        //merge
        $output = MergeViewWithData( $output, $data );
        $output = MergeViewWithExtraElements( $output, $extra_elements );
        $output = MergeViewWithErrors( $output, $errors );
        $output = RemoveEmptyErrorTags( $output, $data );

        print $output;
        ?>

    </div>
</div>

</body>
</html>