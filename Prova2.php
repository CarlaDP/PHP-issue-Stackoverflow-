
<?php
/*
foreach(glob('./Videos/*.*') as $filename){
     echo $filename;

    $delimiter = array(" ",",",".","'","\"","|","\\","/",";",":");
    $replace = str_replace($delimiter, $delimiter[0], $filename);
    $explode = explode($delimiter[0], $replace);

    //echo '<pre>';
    //print_r($explode);
    print($explode[3]);
    //echo '</pre>';
    
    // replaces many symbols in text, then explodes it
}
*/ 
?>


<?php
    $host="localhost";
    $username="root";  
    $password="";  
    $link= mysqli_connect($host,$username,$password);
	
    if(!$link) {
		die("Connessione non riuscita");
	}	
    
    
    $query="CREATE DATABASE ContentSearch"; 
    $result = mysqli_query($link,$query);
	
    if(!$result) {
		die("Creazione DB non riuscita");
	}
    
    
    mysqli_select_db($link,"ContentSearch");
    $query="CREATE TABLE Video (VidId varchar(255), VidPath varchar(255));";
        
    if (mysqli_query($link, $query)) {
        echo "Table Video created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($link);
    }
    
    
    $index = 0;

    foreach(glob('./Videos/*.*') as $filename){
  
        $query="INSERT INTO Video(VIdId,VidPath) values ('Vid" . $index . "', '" . $filename . "')";

        $index++;

        mysqli_query($link,$query);
    }


    $query="CREATE TABLE Keyframe (KeyId varchar(255), KeyPath varchar(255), VidId2 varchar(255));";
        
    if (mysqli_query($link, $query)) {
        echo "Table Keyframe created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($link);
    }


    foreach(glob('./Keyframes/*.*') as $keyname){
        
        $delimiter = array(" ",",",".","'","\"","|","\\","/",";",":");
        $replace = str_replace($delimiter, $delimiter[0], $keyname);
        $explode = explode($delimiter[0], $replace);
    
        //Get the first four characters using substr.
        $firstFourChars = substr($explode[3], 0, 4);
    
        $query="INSERT INTO Keyframe(KeyId,KeyPath,VidId2) values ('" . $explode[3] . "', '" . $keyname . "', '" . $firstFourChars . "')";

        mysqli_query($link,$query);
    }

    
    $query="CREATE TABLE Concept (ConId varchar(255), ConName varchar(255));";
        
    if (mysqli_query($link, $query)) {
        echo "Table Concept created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($link);
    }
    
    
    $query="INSERT INTO Concept(ConId,ConName) values ('Con0', 'Adrenaline'),
                                                        ('Con1', 'Crossfit'),
                                                        ('Con2', 'Sport'),
                                                        ('Con3', 'Training'),
                                                        ('Con4', 'White writings')";

    mysqli_query($link,$query);


    $query="CREATE TABLE KeyframeConcept (KeyConId varchar(255), KeyId varchar(255), ConId varchar(255), Conf varchar(255));";
        
    if (mysqli_query($link, $query)) {
        echo "Table KeyframeConcept created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($link);
    }

    mysqli_query($link,$query);


    foreach(glob('./Results/Cluster 0/*.*') as $keyname){
        
        print($keyname);
        $delimiter = array(" ",",",".","'","\"","|","\\","/",";",":");
        $replace = str_replace($delimiter, $delimiter[0], $keyname);
        $explode = explode($delimiter[0], $replace);
        echo"<br/>";
        echo $explode[5];

        $query = "SELECT * FROM Keyframe WHERE KeyId LIKE '%$explode[5]%'";
        mysqli_query($link,$query);

        print($query);

        while($row = mysqli_fetch_array($query))
			echo "</br>" . $row['KeyId'] . " " . $row['KeyPath'] . " " .$row['VidId2'] . " " . "<br/>" ;

        //Get the first four characters using substr.
        //$firstFourChars = substr($explode[3], 0, 4);
    
        //$query="INSERT INTO Keyframe(KeyId,KeyPath,VidId2) values ('" . $explode[3] . "', '" . $keyname . "', '" . $firstFourChars . "')";
    
    }

    
    
    //$query="INSERT INTO KeyframeConcepts(KeyConId,KeyId,ConId,Conf) values ('KeyCon0', 'Adrenaline'),";

    //mysqli_query($link,$query);

    mysqli_close($link);
   
    	
?>