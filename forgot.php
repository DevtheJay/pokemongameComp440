<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Forgot Page</title>
</head>
    <body>
        <div class="container">
            <div class="box form-box">
                <?php
                include("php/config.php");
                if(isset($_POST['submit'])){
                    $email = $_POST['email'];
                    $question1 = $_POST['question1'];
                    $question2 = $_POST['question2'];
                    $question3 = $_POST['question3'];

                    // Check if email exists
                    $query = mysqli_query($con, "SELECT * FROM users WHERE Email='$email'");
                    if(mysqli_num_rows($query) > 0){
                        $row = mysqli_fetch_assoc($query);
                        // Verify security questions
                        if($question1 === $row['question1'] && $question2 === $row['question2'] && $question3 === $row['question3']){
                            // Send email with username and password
                            $username = $row['Username'];
                            $password =  password_verify($row['PASSWORD']);
                            $message = "Your username is: $username\nYour password is: $password";
                            echo "<div class='message'>
                            <p>$message</p>
                            </div><br>";
                        } 
                        else {
                            echo "<div class='message'>
                            <p>Security questions do not match!</p>
                            </div><br>";
                        }
                    } 
                    else { 
                        echo "<div class='message'>
                        <p>Email does not exist!</p>
                        </div><br>";
                    }
                }
                ?>

            <header>Forgot Username or Password?</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="Email">Enter Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label for="question1">Security Question 1: What is your favorite animal?</label>
                    <input type="question1" name="question1" id="question1" required>
                </div>
                <div class="field input">
                    <label for="question2">Security Question 2: What is your favorite food?</label>
                    <input type="question2" name="question2" id="question2" required>
                </div>
                <div class="field input">
                    <label for="question3">Security Question 3: What is the city you were born?</label>
                    <input type="question3" name="question3" id="question3" required>
                </div>
                <div class="field input">
                <input type="submit" name="submit" class='btn' value="Submit" required>
            </div>
            </div>
        </div>
    </body>
</html>