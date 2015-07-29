<?php
header('Content-type: text/html');
	 header('Access-Control-Allow-Origin: *');
include('simple_html_dom.php');
//access php data from ajax
	
	 
	
	if(isset($_POST['URL']) && !empty($_POST['URL'])) 
	{
		echo 'sucess';
		$siteURL = $_POST['URL'];
	}
	
	// $siteURL = $_REQUEST['URL'];
	//remove $siteURL after your done testing
	
	//$siteURL="http://www.sputnikmusic.com/review/58823/Money-The-Shadow-of-Heaven/";
	//$siteURL="http://www.sputnikmusic.com/review/58977/Drake-Nothing-Was-the-Same/";
	// Create DOM from URL or file
	$html = file_get_html($siteURL);
	
	// Find all images 
	$b=0;
	// Find all links 
	foreach($html->find('a') as $element) 
	{
		   ++$b;
		   //echo $b. '<br>';
		   //when finding the 15th <span> tag
		  if($b == 15)
		  {
			  $band=$element->innertext;
			  $bands = str_replace('<img style="margin-left:4px;" src="/images/bandlink.png" border="0">', '', $band);
			  
			  echo $bands . '<br>';
			  
		  }
		   
	}
	/**********************************************TESTING********************************************
	var_dump($bands);
	*/
	$band=str_replace(' ', '+', $bands);
	$c=0;
	foreach($html->find('span') as $element) 
	{
			
		   ++$c;
		   
		   //when finding the 1st <span> tag
		  if($c == 1)
		  { 
			$album=$element->innertext;
			echo $element->innertext . '<br>';
		  }		 
		  
		   
	}
	var_dump($album);
    $albums=str_replace(' ', '+', $album);
	$str=bin2hex($album);
	
	
	$tinylink='http://tinysong.com/s/'.$bands.'+'.$albums.'?format=json&limit=32&key=c4dba9a79f662aacdf9e243627150dd8';
	//echo $tinylink;
	echo "<br />";
	$file = file_get_contents($tinylink ,true);
	$data=json_decode($file);
	//echo $data;
	
	$i=0;
	foreach ($data as $obj)
	{
		
	
		
			foreach ($obj as $key => $song) {
			
				switch($key)
				{
					case 'Url':
						$Url=$song;	
						break;
					case 'SongID':
						$SongID=$song;	
							break;
					case 'SongName':
						$SongName=$song;
							break;
					case 'ArtistID':
						$ArtistID=$song;
							break;
					case 'ArtistName':
						$ArtistName=$song;	
							break;
					case 'AlbumID':
						$AlbumID=$song;
							break;
					case 'AlbumName':
						$AlbumName=$song;
							break;
					
				}
				
			}
				if($AlbumName == true || $album === $AlbumName && $bands === $ArtistName)
				{
					echo  $Url ;
					
					echo '<p>' . $SongID . '</p><br>';
					echo '&nbsp&nbsp&nbsp' . $SongName . ' <br>';
					echo '<p>' . $ArtistID . '</p><br>';
					echo '<p>' . $ArtistName . '</p><br>';
					echo '<p>' . $AlbumID . '</p><br>';
					echo '<p>' . $AlbumName . '</p><br>';
					//echo "Binary Representation:";
					echo bin2hex($AlbumName) . '<br>';
				}	
				//TESTING document.write("Sucess");
				
				
			     echo "<br />";
				 
				 
		
	}
	
?>

