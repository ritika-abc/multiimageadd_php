<?php
// Check if form is submitted
if(isset($_POST['submit'])) {
    
    // Database connection (adjust according to your database setup)
    $conn = new mysqli('localhost','root', '','new_cart');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if files are uploaded
    if(isset($_FILES['images']['name']) && count($_FILES['images']['name']) > 0) {

        // Prepare an array to store file names
        $image_list = array();

        // Loop through each file
        for($i=0; $i<count($_FILES['images']['name']); $i++) {
            
            $file_name = $_FILES['images']['name'][$i];
            $temp_name = $_FILES['images']['tmp_name'][$i];
            
            // Check if file is uploaded successfully
            if(move_uploaded_file($temp_name, 'upload/' . $file_name)) {
                // Store file name in array
                $image_list[] = 'upload/' . $file_name; // Adjust path as per your setup
            }
        }

        // Insert into database
        if(!empty($image_list)) {
            // Serialize or JSON encode $image_list as per your preferred method
            $image_data = json_encode($image_list);

            // Insert query
            $sql = "INSERT INTO  `image`(images) VALUES (?)";
            
            // Prepare statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $image_data);

            // Execute statement
            if($stmt->execute()) {
                echo "Images uploaded and inserted successfully.";
            } else {
                echo "Error inserting images: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }

    } else {
        echo "No images uploaded.";
    }

    // Close connection
    $conn->close();
}
?>
