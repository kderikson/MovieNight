<?php
$movienum = intval($_GET['q']);

$db = mysqli_connect('localhost', 'root', 'root', 'movienight');
if(!$db) {
	die('Could not connect: ' . mysql_error($db));
}

$sql = "SELECT ID, Link FROM movielist WHERE ID = '$movienum'";

$result = mysqli_query($db,$sql);

while($row = mysqli_fetch_array($result)) {
	$rank = $row['ID'];
	$link = $row['Link'];

}
$json = file_get_contents("http://www.omdbapi.com/?i=$link");

$movieitems = json_decode($json);

$title = $movieitems->Title;
$year = $movieitems->Year;
$rating = $movieitems->Rated;
$released = $movieitems->Released;
$runtime = $movieitems->Runtime;
$genre = $movieitems->Genre;
$director = $movieitems->Director;
$actors = $movieitems->Actors;
$plot = $movieitems->Plot;
$awards = $movieitems->Awards;
$poster = $movieitems->Poster;
$metascore = $movieitems->Metascore;
$imdbrating = $movieitems->imdbRating;

echo '<div class="col-xs-3" id="poster">
        <img id="poster" src="'.$poster.'">
     </div>
     <div class="col-xs-8">
        <div id="blur-bg" class="col-xs-9 full"></div>
        <div id="blur">
           	<h1>'.$title.'</h1>('.$year.')
            <p class="lead">'.$plot.'</p>
            <p><b>Director: </b>'.$director.'</p>
            <p><b>Stars: </b>'.$actors.'</p>
        </div>
                    
     </div>';

mysqli_close($db);
?>