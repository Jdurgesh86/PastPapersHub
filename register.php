<?php
    error_reporting(0); //this show no errors or warning

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


    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        $message = ""; // Initialize an empty message

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $prn = $_POST["prn"];
        $full_name = $_POST["fullname"];
        
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and execute the SQL query to insert data into the "users" table
        $sql = "INSERT INTO users (username, email, password, prn, full_name)
                    VALUES ('$username', '$email', '$hashed_password', '$prn', '$full_name')";

        if ($conn->query($sql) === TRUE) 
        {
            $message = "<div class=\"success-message\">";
            $message .= "<p>Registration successful!</p>";
            $message .= "</div>";
        } 
        else
        {
            $message = "<div class=\"error-message\">";
            echo "Error: " . $sql . "<br>" . $conn->error;
            $message ="somthing went wrong message screenshot to admin 8010117022";
            $message .= "</div>";
        }
    }
    $conn->close();
?>


<!-- html code for attractiveness -->

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* New CSS styles for messages */
        .success-message {
            font-family: Arial, sans-serif;
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .error-message {
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
    <?php echo $message; ?>
    <a href="index.html">Go Back</a>
</body>
</html>
