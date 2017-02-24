<?php
include 'navbar.php';
?>
<div class="container">

      <div class="artist-data-div">
        <h2>Artists Data List (Part 1)</h2>
        <?
        	
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = 'abcdef@123';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
    $sql = 'SELECT ArtistID, FirstName, LastName, YearOfBirth, YearOfDeath FROM artists order by LastName ASC ';
   mysql_select_db('artists_db');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   echo '<form>';
   while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
      echo "<a href='Part02_SingleArtist.php?ArtistID={$row['ArtistID']}' id='{$row['ArtistID']}' class='artist'> {$row['FirstName']} {$row['LastName']} ( {$row['YearOfBirth']} - {$row['YearOfDeath']} )</a><br> ";
   }
   echo "</form>";
    mysql_close($conn);
?>
      </div>
      </div>

    
