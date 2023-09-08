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

    $message = ""; 

    session_start(); // Start PHP session to check if the user is logged in

//------------------------------------------ Filter logic starts-----------------------------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    // Server-side filtering logic for question papers
        $filters = array(
            "university" => $_POST["university"],
            "department" => $_POST["department"],
            "departmental_year" => $_POST["departmental_year"],
            "semester" => $_POST["semester"],
            "type" => $_POST["type"]
        );

        $sql = "SELECT file_name FROM question_papers";
        $conditions = array();

        foreach ($filters as $field => $value)
        {
            if (!empty($value))
            {
                $conditions[] = "$field = '$value'";
            } 
        }

        if (!empty($conditions))
        {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $conn->query($sql);

        if ($result->num_rows < 1)
        {
            $message = "<div class=\"error-message\">";
            $message .= "<p>No question papers found with the selected criteria.</p>";
            $message .= "</div>";
        }
    }
$conn->close();
?>

<!-- ------------------------------------------ Filter logic Ends----------------------------------------- -->

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

        .error-message
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
    </style>
</head>

<body>
    <h1>Filtered Question Paper</h1>

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
    
    <?php echo $message; ?>
    <a href="download.html">Go Back</a>
</body>
</html>

