<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reacher</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Background Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,rgb(45, 83, 144),rgb(48, 93, 178)); /* Soft Green and Muted Green Blend */
            color: white;
            text-align: center;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Title Styling */
        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0px 0px 15px rgba(255, 195, 50, 1), 0px 0px 25px rgba(255, 195, 50, 0.7); /* Glowing Effect */
            margin-bottom: 10px;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 600; /* Increased boldness */
            color: #ddd;
            margin-bottom: 30px;
        }

        /* Search Box */
        .search-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.4);
            width: 60%;
            max-width: 600px;
            text-align: center;
        }

        input[type="file"] {
            padding: 14px;
            font-size: 1rem;
            border: 2px solid #6A9C57; /* Muted Green Border */
            border-radius: 12px;
            background: #ecf0f1;
            cursor: pointer;
            transition: 0.3s;
            color: #2c3e50;
            font-weight: bold;
        }

        input[type="file"]:hover {
            background: #d5dbdb;
        }

        input[type="submit"] {
            background: #F1C232; /* Soft Yellow */
            color: white;
            font-size: 1.2rem;
            border: none;
            padding: 14px 30px;
            cursor: pointer;
            border-radius: 12px;
            margin-left: 15px;
            transition: 0.3s;
            font-weight: bold;
            box-shadow: 0px 5px 12px rgba(255, 195, 50, 0.5);
        }

        input[type="submit"]:hover {
            background: #f0b90d;
            transform: scale(1.07);
        }

        /* Results Table */
        table {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
        }

        th, td {
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            font-size: 1.2rem;
            color: white;
        }

        th {
            background: rgba(255, 195, 50, 0.8); /* Soft Yellow */
            font-weight: bold;
        }

        td img {
            max-width: 120px;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        td img:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>

    <h1>Reacher</h1>
    <h3>Your Visual Search Helper</h3>

    <div class="search-container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="image" id="image">
            <input type="submit" value="Check" name="check">
        </form>
    </div>

    <?php
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mystore";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // IMAGE SEARCH FUNCTIONALITY
    if (isset($_POST['check']) && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $temp_image = "C:/xampp/htdocs/Ai_driven_ecommerce/temp_image.png"; // Save temporarily for comparison
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $temp_image)) {
            // Call Python script for similarity check
            $python_script = "C:/xampp/htdocs/Ai_driven_ecommerce/compare_images.py";
            $command = escapeshellcmd("python \"$python_script\" \"$temp_image\""); 
            $output = shell_exec($command . " 2>&1");

            echo "<h2>Search Results</h2>";
            echo "<table>";
            echo "<tr><th>Product ID</th><th>Product Title</th><th>Image</th><th>Similarity Score</th></tr>";

            // Process the output from Python script
            $lines = explode("\n", trim($output));
            foreach ($lines as $line) {
                $data = explode(",", $line);
                if (count($data) == 4) {
                    list($product_id, $product_title, $image_name, $score) = $data;
                    echo "<tr><td>{$product_id}</td><td><a href='http://localhost/Ai_driven_ecommerce/users_area/product.php?product_id={$product_id}' style='color: inherit; text-decoration: none;'>{$product_title}</a></td><td><img src='admin_area/product_images/{$image_name}'></td><td>{$score}</td></tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>Error saving temporary image.</p>";
        }
    } elseif (isset($_POST['check'])) {
        echo "<p style='color: red;'>No image selected for checking.</p>";
    }

    // Close database connection
    mysqli_close($conn);
    ?></body>
</html>