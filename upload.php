<?php
if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $id = $_POST["id"];
        $imgContent = addslashes(file_get_contents($image));

        /*
         * Insert image data into database
         */
        
        //DB details
        $dbHost     = '';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName     = '';
        $dbport = 3306;
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbport);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        
        //$dataTime = date("Y-m-d H:i:s");
        
        //Insert image content into database
        $insert = $db->query(" UPDATE imagenes SET imagen = '$imgContent' where imagenes.id = '$id'");

        if($insert){
            echo "File uploaded successfully.";
        }else{
            echo "File upload failed, please try again.";
        } 
    }else{
        echo "Please select an image file to upload.";
    }
}
?>
