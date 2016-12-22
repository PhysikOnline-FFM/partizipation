<!DOCTYPE html>
<html>
<head>
    <title>Test zum Tag der Partizipation</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
	        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

	        $all_files = scandir( "./" );
            $all_files = array_slice( $all_files, 2, count( $all_files ) - 2 );
            $extensions = [ "jpg", "png" ];
    
            for ( $i = 0; $i < count( $all_files ); ++$i )
            {
                $info = new SplFileInfo( $all_files[$i] );
                if ( ! in_array( $info->getExtension(), $extensions ) )
                {
                    array_splice( $all_files, $i, 1 );
                }
            }
            
            // sort files so that last modified file is at index 0
            usort( $all_files, function ( $A, $B ) 
            {
                return filemtime( $B ) - filemtime( $A );        
            } );
            ?>
            <ol class="carousel-indicators">
                <?php
                echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
                for ( $i = 1; $i < count( $all_files ); ++$i )
                {
                    echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
                }
                ?>
            </ol>

            <div class="carousel-inner" role="listbox">
                <?php
                echo '<div class="item active">
                        <img src="'.$all_files[0].'"alt="Erstes Bild">
                      </div>';
                for ( $i = 1; $i < count( $all_files ); ++$i )
                {
                    echo '<div class="item">
                            <img src="'.$all_files[$i].'" alt="'.$i.'. Bild">
                          </div>';
                }
                ?>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <script>var sharebutton_is_horizontal = false; document.write('<script src="//cdn.sharebutton.to/lib/share9.js"></scr' + 'ipt>');</script>
    </div>
    
</body>
</html>
