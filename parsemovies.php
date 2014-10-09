<?php

//Necessary parsing library for HTML
include('simple_html_dom.php');

//Create a new connection for the database
$db = new mysqli('localhost', 'root', 'root', 'movienight');

//Check to make sure the connection is working
if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

//Grab teh HTML contents of the 250 films website
$html = file_get_html('http://www.250films.net/lists/imdb-top-250');

//Loop through each movie and grab IMDB Rank, Title, and part of IMDB Link
foreach($html->find('span[class=ranking]') as $item) {
    
    //Grab the IMDB Rank
    $rank = $item->plaintext;
    
    //Traverse to next DOM sibling
    $item = $item->next_sibling();

    //Loop through the movie titles
    foreach($item->find('span[class=name]') as $item) {
    
    //Grab the movie title
    $title = $item->plaintext;
    
    //Move to the next DOM sibling
    $item = $item->next_sibling();
    
    //Loop through the movie's IMDB links
    foreach($item->find('a[class=imdb-link]') as $link) {
        //Grab the link
        $link = $link->href;
        
        //Eliminate all the forward slashes and put URL into array
        $linkarray = explode('/', $link);

        //Grab the part containing IMDB's movie identifier
        $code = $linkarray[count($linkarray)-2];
    }

    //Replace any titles apostrophes with empty spaces for SQL
    $title = str_replace("'", "", $title);

    //SQL statement to insert the movie into the DB
    $sql = "INSERT INTO movielist (ID, Title, Link) VALUES ('$rank', '$title', '$code')";

    //Run the query and output an error if the query fails
    if (!mysqli_query($db,$sql)) {
        die('Error: ' . mysqli_error($db));
    }    
}

    
}

//Close the DB connection
mysql_close($db);




?>