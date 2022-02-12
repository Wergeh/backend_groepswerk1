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
                "last_name" => $old_post['last_name'],
                "first_name" => $old_post['first_name'],
                "FK_nationaliteitID" => $old_post['FK_nationaliteitID']
            ]
            ];
        }
        else $data = [ 0 => [ "last_name" => "", "first_name" => "", "FK_nationaliteitID" => "" ]];
        $row=$data[0];

        //get template
        $output = file_get_contents("templates/addAthlete.html");

        //add extra elements
        $extra_elements['csrf_token'] = GenerateCSRF( "addAthlete.php"  );
        $extra_elements['select_Nationality'] = MakeSelect( $fkey = 'FK_nationaliteitID',
            $value = $row['FK_nationaliteitID'] ,
            $sql = "select nationaliteitID, nationaliteit from nationaliteit order by nationaliteit" );

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