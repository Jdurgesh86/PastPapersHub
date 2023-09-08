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
    //------------------------------------------ connection code Ends-----------------------------------------

    // Start PHP session to store user login status
        session_start(); 
    // Initialize an empty message
        $message = ""; 
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $username = $_POST["username"];
            $password = $_POST["password"];

        // Prepare and execute the SQL query to retrieve user data from the "users" table
            $sql = "SELECT id, username, password FROM users WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
            // Verify the password
                if (password_verify($password, $row["password"])) 
                {
                // Password is correct, set session variables and redirect 
                    $_SESSION["user_id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    header("Location: download.html"); 
                    exit;
                }
                else 
                {
                    $message = "<div class=\"error-message\">";
                    $message .= "<p>Invalid username or password. Please try again.</p>";
                    $message .= "</div>";
                }
        } 
        else
        {
            $message = "<div class=\"error-message\">";
            $message .= "<p>Invalid username or password. Please try again.</p>";
            $message .= "</div>";
        }
    }
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* New CSS styles for messages */
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
    <a href="index.html">Go Back</a>
    <?php echo $message; ?>
</body>
</html>
