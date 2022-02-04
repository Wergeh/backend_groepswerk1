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
        //toon messages als er zijn
        foreach ( $msgs as $msg )
        {
            print '<div class="msgs">' . $msg . '</div>';
        }

        //get data
        $data = GetData( "select * from images" );

        //get template
        $template = file_get_contents("templates/column.html");

        //merge
        $output = MergeViewWithData( $template, $data );
        print $output;
        ?>

    </div>
</div>

</body>
</html>