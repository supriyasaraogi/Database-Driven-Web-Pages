<?php
include 'navbar.php';
?>
<div class="container">

      <div class="artist-data-div">
      
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
   ?>
   <h2>Search Results</h2>
      <div class="well well-lg">
      <form>
       <div class="radio">
      <label><input type="radio" name="search-title" checked="checked">Search by Title:</label>
    </div>
    <input type="text" class="form-control" id="search-bar">
     <div class="radio">
      <label><input type="radio" name="search-description">Search by Description:</label>
    </div>
     <div class="radio">
      <label><input type="radio" name="no-filter">No filter (show all art works):</label>
    </div>
    <button type="button" class="btn btn-primary">Filter</button>

        </form>
        </div>

<?

    mysql_close($conn);
?>
      </div>
      </div>

    





<!-- <div class="container" id="result-div">
  <div class="row" id="search-results">
                  <div class="col-md-2">
                        <a href="Part03_SingleWork.php?ArtWorkID=<?php echo $ArtWorkID;?>" ><img class = "img-thumbnail" src="images/works/square-medium/<?php echo $image?>.jpg"></a>
                 </div>
                  <div class="col-md-8">
                      <p><a href='Part03_SingleWork.php?ArtWorkID=<?php echo $ArtWorkID?>' > <?php echo highlight($Title, $text) ?></a></p>
                      <p><?php echo highlight($Description, $text) ?> </p>
                  </div>
              </div> -->

  <?
$sql=" ";
$text=" ";
$filter=" ";
if(isset($_POST['filter'])){
    $filter=$_POST['filter'];

           if($filter=='checked-title'){
                $text=$_POST['text_to_search'];
               $sql = "SELECT * FROM artists as a, artworks as aw where a.ArtistID=aw.ArtistID and aw.Title like '%$text%'"; 
           }
           if($filter=='checked-description'){
              $text=$_POST['description_to_search'];
              $sql = "SELECT * FROM artists as a, artworks as aw where a.ArtistID=aw.ArtistID and aw.Description like '%$text%'"; 
           }
           if($filter=="checked-all"){
            //echo "all";
              $sql = "SELECT * FROM artists as a, artworks as aw where a.ArtistID=aw.ArtistID";
           }

           
           mysql_select_db('wedatadb');
           $retval = mysql_query( $sql, $conn );
           
           if(! $retval ) {
              die('Could not get data: ' . mysql_error());
           }
           
           while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
              $Title=$row['Title'];
              $Description=$row['Description'];
              $image=$row['ImageFileName'];
              $ArtWorkID=$row['ArtWorkID']
              ?>
              <div class="row" id="search-results">
                  <div class="col-md-2">
                        <a href="Part03_SingleWork.php?ArtWorkID=<?php echo $ArtWorkID;?>" ><img class = "img-thumbnail" src="images/works/square-medium/<?php echo $image?>.jpg"></a>
                 </div>
                  <div class="col-md-8">
                      <p><a href='Part03_SingleWork.php?ArtWorkID=<?php echo $ArtWorkID?>' > <?php echo highlight($Title, $text) ?></a></p>
                      <p><?php echo highlight($Description, $text) ?> </p>
                  </div>
              </div>
              <?php
           
            }
          }
          
?>
  
</div>