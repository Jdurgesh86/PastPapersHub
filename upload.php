<?php
//------------------------------------------ connection code -----------------------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "question_papers_db";
error_reporting(0);
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//------------------------------------------ connection code Ends----------------------------------------

session_start(); // Start PHP session to check if the user is logged in

$message = ""; // Initialize an empty message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"]) && isset($_SESSION["user_id"])) {
    // Get the user ID from the session
    $user_id = $_SESSION["user_id"];

    $targetDir = "question_papers/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory with full permissions (0777)
    }
    // Get the file information
    $fileName = basename($_FILES["file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    // Allow only specific file types (e.g., pdf, docx, etc.)
    $allowedTypes = array("pdf", "docx","jpg");
    if (!in_array($fileType, $allowedTypes)) {
        $message = "<div class=\"error-message\">";
        $message .= "<p>Error: Only PDF,DOCX and jpg files are allowed.</p>";
        $message .= "</div>";
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Prepare and execute the SQL query to insert file metadata into the "question_papers" table
        $university = $_POST["university"];
        $department = $_POST["department"];
        $departmental_year = $_POST["departmental_year"];
        $question_paper_year = $_POST["question_paper_year"];
        $semester = $_POST["semester"];
        $type = $_POST["type"];

        $sql = "INSERT INTO question_papers (user_id, university, department, departmental_year, question_paper_year, semester, type, file_name)
                VALUES ('$user_id', '$university', '$department', '$departmental_year', '$question_paper_year', '$semester', '$type', '$fileName')";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class=\"success-message\">";
        $message .= "<p>File uploaded. successfully!</p>";
        $message .= "</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "";
        $message = "<div class=\"error-message\">";
        $message .= "<p>Error uploading file.</p>";
        $message .= "</div>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* New CSS styles for messages */
        .success-message {
            background-color: #e6ffe6;
            border: 1px solid #66cc66;
            padding: 10px;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #ffe6e6;
            border: 1px solid #ff6666;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php echo $message; ?>
</body>
</html>
