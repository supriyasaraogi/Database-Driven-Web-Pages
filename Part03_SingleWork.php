<?php
include 'navbar.php';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'abcdef@123';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}


mysql_select_db('artists_db');


	$artid =mysql_real_escape_string($_REQUEST['artid']); 
    //$artid=null;
	//$input=null;
	
	$dir= 'images/artists/medium/';
	$dir2='images/works/square-medium/';
	$input= $_GET['artid'];
		
			$check ="select count(ArtWorkID) as t1 from artworks where ArtWorkID =".$artid.";";
			
			$check2= "select count(ArtWorkID) as total from artworks where ArtWorkID ==".$input.";";
			
			$s3= "SELECT ArtWorkID,ImageFileName,Title,Description,TRUNCATE(MSRP,2)as msrp,A.FirstName as f1, A.LastName as f2, artworks.ArtistID as a1 from artists as A INNER Join artworks on A.ArtistID=artworks.ArtistID and Artworks.ArtWorkID in" . "(" . $artid. ",". $input.")".";";
	
			$s4= "SELECT date_format(DateCreated, '%m/%d/%y') as d1 from orders where orders.OrderID in (select OrderID from orderdetails where ArtWorkID IN". "(" . $artid. ",". $input."));" ;

			$s5= "SELECT YearOfWork,Medium,OriginalHome,Width,Height FROM artworks where ArtWorkID IN". "(" . $artid. ",". $input.")" .";";

			$genreCountSql = "SELECT count(DISTINCT g.GenreName) as countGNames from genres AS g INNER Join artworkgenres AS a on g.GenreID = a.GenreID where a.ArtWorkID IN"."(" . $artid. ",". $input.")" .";"; 

			$s6= "SELECT DISTINCT(g.GenreName)as gname from genres AS g INNER Join artworkgenres AS a on g.GenreID = a.GenreID where a.ArtWorkID IN"."(" . $artid. ",". $input.")" .";"; 

			$subjectNameCountSql = "SELECT count(DISTINCT s.SubjectName) as SNameCount from subjects as s INNER JOIN artworksubjects AS a ON s.SubjectID=a.SubjectID where a.ArtWorkID IN". "(" . $artid. ",". $input.")" .";";

			$s7="SELECT DISTINCT(s.SubjectName)as sname from subjects as s INNER JOIN artworksubjects AS a ON s.SubjectID=a.SubjectID where a.ArtWorkID IN". "(" . $artid. ",". $input.")" .";";
			
			
			$result3 = mysql_query($s3, $conn);
			
			$result4= mysql_query($s4, $conn);
			$result5 = mysql_query($s5, $conn);
			$result6= mysql_query($s6, $conn);
			$result7= mysql_query($s7, $conn);
			$subjectNameResult = mysql_query($subjectNameCountSql, $conn);
			$genreCountResult = mysql_query($genreCountSql, $conn);
			
			$decide = mysql_query($check, $conn);
			$decide2= mysql_query($check2, $conn);
			$r = mysql_fetch_array($decide2, MYSQL_ASSOC); //do not change
			
			$s = mysql_fetch_array($decide, MYSQL_ASSOC); //do not change
			
			
			
			if(($s["t1"]==1) or ($r["total"]==1)) //checks for right parameter id
			{
				echo '<div class="container">'; // main div
					echo '<div class="artist-data-div">';
					echo '<div class="row">';    

					
			 while($row = mysql_fetch_array($result3, MYSQL_ASSOC))
	 			{
					$workTitle = $row["Title"];
					$firstName = $row["f1"];
					$lastName = $row["f2"];
					$imageFileName = $row["ImageFileName"];  
					echo '<div class="col-lg-12">';
					echo '<h3>'.$row["Title"].'</h3>';
					echo '<p>By <a href="Part02_SingleArtist.php?ArtistID='.$row["a1"].'">'.$row["f1"].' '.$row["f2"].'</a></p>';
					echo '</div>'; 

					echo '<div class="col-md-3">';
					echo '<a href="#imageModal" role="button" data-toggle="modal"><img src="'.$dir2.$row["ImageFileName"].'.jpg'.'"'.'alt="no image"'.'width="300" height="450"'.'class="img-thumbnail"></a>';
					echo '</div>'; // for image div


					echo '<div class="col-md-5">';
						if($row["Description"]==null){
						echo "No description available";
					}
					else{
					    echo '<p>'.$row["Description"].'</p>';
					}

					echo '<p class = "red-bold-font">'.$row["msrp"].'</p>';
					echo  '<button type="button " class="btn btn-default pz "><a href="#"> <span class="glyphicon glyphicon-gift"> </span> Add to Wish list</a>
							</button>';
					echo  '<button type="button " class="btn btn-default pz "><a href="#"> <span class="glyphicon glyphicon-shopping-cart"> </span> Add to Shopping Cart</a>
							</button> <p> </p>';
					
					
				}
					

					echo '<table class="table">
						 <thead><tr class="active"><th><b>Product Details </b></th>
						 						<th>       </th> 
						 		</tr></thead> 
						 <tbody>';



     			while($row3= mysql_fetch_array($result5, MYSQL_ASSOC))	
				{		
					$yearOfWork = $row3["YearOfWork"];
                    echo'<tr> <td> <b>Date:</b> </td>';     
					echo '<td>'.$row3["YearOfWork"].'</td></tr>';			
					echo '<tr> <td> <b> Medium: </b></td>';
        			echo '<td>'.$row3["Medium"].'</td>';
        			echo '<tr> <td> <b> Dimensions: </b></td>';
					echo '<td>'.$row3["Width"]."*".$row3["Height"].' </td></tr>';
					echo '<tr> <td> <b> Home: </b></td>';
					echo '<td>' .$row3["OriginalHome"]. '</td></tr>';
				}					
				

				while($temprow= mysql_fetch_array($genreCountResult, MYSQL_ASSOC))
				{    
        			$rowspanValue = intval($temprow["countGNames"])+1;
				}

				echo '<tr> <td rowspan='.$rowspanValue.'> <b> Genres: </b></td></tr>';
				
				while($row4= mysql_fetch_array($result6, MYSQL_ASSOC))
				{    
        			echo '<tr><td>'.'<a href="#">'.$row4["gname"].'</td></tr>';
				}
				

				while($temprow2 = mysql_fetch_array($subjectNameResult, MYSQL_ASSOC)){
					$subjectRowSpanValue = intval($temprow2["SNameCount"])+1;
				}

				echo '<tr><td rowspan='.$subjectRowSpanValue.'><b> Subjects: </b></td></tr>';
				while($row5= mysql_fetch_array($result7, MYSQL_ASSOC))
				{				
			        
					echo '<td>'.'<a href="#">'.$row5["sname"].'</td> </tr>';
				}
       				echo'</tbody>';
					echo'</table>';





					echo '</div>'; // col-md-4  



  				echo '<table class="sales-table">';
						 echo '<thead><tr class="active"><th><b>Sales </b></th>
						 		</tr></thead> 
						 <tbody>';
				while($row6= mysql_fetch_array($result4, MYSQL_ASSOC)){
					
					
					echo '<tr><td>'.$row6["d1"].'</td></tr>';
				}


					echo '</div>'; //row 
				


				echo '</div>'; // artist-data-div

				echo '</div>'; // main container		
  				
?>

				<!-- Modal -->
  <div class="modal fade" id="imageModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?echo $workTitle." (".$yearOfWork.") by ".$firstName." ".$lastName;?></h4>
        </div>
        <div class="modal-body">
          <?echo '<img src="'.$dir2.$imageFileName.'.jpg'.'"'.'alt="no image"'.'height="500" width="400"'.'class="img-thumbnail">'?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<?

				
				}
				
			else
					{
						include 'error.php';

					
			
}

	 	     mysql_close($conn);

?>


