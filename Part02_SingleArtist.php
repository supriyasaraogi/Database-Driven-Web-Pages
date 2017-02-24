<?php
include 'navbar.php';
?>

<div class="container">

      <div class="artist-data-div">
      <?

$artist_id = $_GET['ArtistID'];
$dir= 'images/artists/medium';
$dir2='images/works/square-medium';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'abcdef@123';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
$sql = "SELECT FirstName, LastName, YearOfBirth, YearOfDeath, Nationality, Details, ArtistLink, ArtistID FROM artists where ArtistID = '$artist_id';";
mysql_select_db('artists_db');
$retval = mysql_query($sql, $conn);

if (!$retval) {
    die('Could not get data: ' . mysql_error());
}


while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
?>


<div class='row'>
            <div class='col-lg-12'>
                <h3> <?
    echo "{$row['FirstName']} {$row['LastName']}";
?>
                </h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class='row'>

            <div class='col-md-2'>
                <img class='img-thumbnail it gap-left' src='<?echo "$dir/$artist_id";?>.jpg' width="200" height="400" alt=''>
            </div>

            <div class='col-md-5'>
                <p><?
    echo "{$row['Details']}";
?></p>
                <p><button type="button" class="btn btn-default pz"><a href="#"><span class="glyphicon glyphicon-heart"></span> Add to Favorites List</button></a></p>
               <table class="table">
  <thead><tr class="active"><th><b>Artist Details </b></th>
						 						<th>       </th> 
						 		</tr></thead>
  <tbody>
    <tr>
      <td><b>Date:</b> </td>
      <td><?
    echo "{$row['YearOfBirth']} - {$row['YearOfDeath']}";
?></td>
    </tr>
    <tr>
      
      <td><b>Nationality:</b> </td>
      <td><?
    echo "{$row['Nationality']}";
?></td>
    </tr>
    <tr>
      
      <td><b>More Info:</b> </td>
      <td><?
    echo "{$row['ArtistLink']}";
?></td>
    </tr>
  </tbody>
</table>
            </div>

        </div>
        <!-- /.row -->



         <div class='row'>

            <div class='col-lg-12'>
                <h3>Art by <?
    echo "{$row['FirstName']} {$row['LastName']}";
?></h3>
            </div>

           
        </div>

<?
}

$sql2 = "SELECT ImageFileName, Title, YearOfWork, ArtWorkID FROM artists , artworks where artists.ArtistID = '$artist_id' AND artists.ArtistID = artworks.ArtistID;";
mysql_select_db('artists_db');

$retval2 = mysql_query($sql2, $conn);

if (!$retval2) {
    die('Could not get data: ' . mysql_error());
}

mysql_close($conn);
?>
        
        <div class='row'>
        <?
while ($row2 = mysql_fetch_array($retval2, MYSQL_ASSOC)) {
?>
            <div class='col-md-offset-0 col-md-3 text-center'>
                <a href='Part03_SingleWork.php?artid=<?echo "{$row2["ArtWorkID"]}";?>' class="thumbnail">
                    <img class='img-thumbnail' src='<?
    echo "$dir2/{$row2['ImageFileName']}";
?>.jpg' alt=''>
                    <p><?
    echo "{$row2['Title']}, {$row2['YearOfWork']}";
?></p>

<p><button type="button " class="btn btn-sm btn-primary"> <span class="glyphicon glyphicon-info-sign custom"> </span> View </button>
<button type="button " class="btn btn-sm btn-success text-center"> <span class="glyphicon glyphicon-gift custom"> </span> Wish</button>
<button type="button " class="btn btn-sm btn-info"> <span class="glyphicon glyphicon-shopping-cart custom "> </span> Cart</button></p>
                </a>
            </div>
<?
}
?>           
        </div>
        <!-- /.row -->

      </div>
      </div>