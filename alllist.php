<?php
    error_reporting(0);
//------------------------------------------ connection code -----------------------------------------
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "question_papers_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//------------------------------------------ connection code Ends-----------------------------------------

    $message = ""; // Initialize an empty message

    session_start(); // Start PHP session to check if the user is logged in

    $sql = "SELECT * FROM question_papers WHERE";
    $sql .= " 1"; // No filters applied, return all rows
    $result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download Question Papers</title>
    <style>
        table 
        {
            border-collapse: collapse;
            width: 100%;
        }

        th, td 
        {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th 
        {
            background-color: #f2f2f2;
        }

        tr:hover 
        {
            background-color: #f2f2f2;
        }
        body 
        {
            font-family: Arial, sans-serif;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 
        {
            text-align: center;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>All Question Papers</h1>

    <?php
        echo "<table>";
        echo "<tr><th>University</th><th>Department</th><th>Departmental Year</th><th>Question Paper Year</th><th>Semester</th><th>Type</th><th>File Name</th></tr>";
        while ($row = $result->fetch_assoc()) 
        {
            echo "<tr>";
            echo "<td>{$row['university']}</td>";
            echo "<td>{$row['department']}</td>";
            echo "<td>{$row['departmental_year']}</td>";
            echo "<td>{$row['question_paper_year']}</td>";
            echo "<td>{$row['semester']}</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td><a href=\"question_papers/{$row['file_name']}\" target=\"_blank\">{$row['file_name']}</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
    <a href="download.html">Go Back</a>
</body>
</html>


