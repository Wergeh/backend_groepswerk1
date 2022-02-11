<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "lib/autoload.php";

PrintHead();
PrintJumbo( $title = "change record", $subtitle = "" );
?>

<div class="container">
    <div class="row">

        <?php
        if ( ! is_numeric( $_GET['recordID']) ) die("Ongeldig argument " . $_GET['recordID'] . " opgegeven");

        //get data
        $data = GetData( "select * from record where recordID=" . $_GET['recordID'] );
        $row = $data[0]; //there's only 1 row in data

        //add extra elements
        $extra_elements['csrf_token'] = GenerateCSRF( "record_form.php"  );
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
            $sql = 'select sports.id, concat_ws(" ", sports.name,c.name) as sport from sports inner join cat c on sports.cat_id = c.id' );


        //get template
        $output = file_get_contents("templates/record_form.html");

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
