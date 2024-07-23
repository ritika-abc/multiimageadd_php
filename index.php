<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Images</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple>
        <button type="submit" name="submit">Upload</button>
    </form>


    <table>
        <thead>
            <tr>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection (adjust according to your database setup)
            $conn = new mysqli('localhost','root', '','new_cart');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Select query
            $sql = "SELECT * FROM `image`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Decode the JSON data to get the array of image paths
                    $image_list = json_decode($row['images'], true); // true to get an associative array

                    // Display images
                    if (!empty($image_list)) {
                        foreach ($image_list as $image) {
                            echo '<tr><td><img src="' . $image . '" alt="Image"></td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="1">No images found.</td></tr>';
                    }
                }
            } else {
                echo '<tr><td colspan="1">No images found in the database.</td></tr>';
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>