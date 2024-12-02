<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="box form-box">
        <?php
        include("php/config.php");
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $Fname = $_POST['Fname'];
            $Lname = $_POST['Lname'];
            $birth_date = $_POST['Birth_date'];
            $question1 = $_POST['question1'];
            $question2 = $_POST['question2'];
            $question3 = $_POST['question3'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];


             // Convert birth date from mm-dd-yyyy to yyyy-mm-dd
            $date_parts = explode('-', $birth_date);
            if (count($date_parts) == 3) {
                $birth_date = $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1];
            } 
            else {
            // Handle invalid date format
                echo "<div class='message'>
                <p>Invalid date format! Please enter the date in the format mm-dd-yyyy.</p>
                </div>";
                exit;
            }
            //Verifying unique email
            $verify_query= mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
            if(mysqli_num_rows($verify_query) != 0){
                echo "<div class= 'message'>
                <p>Email already exists! Try another one!</p>
                </div><br>";
            }
            else{
                // Check if passwords match
                if($password !== $confirm_password){
                    echo "<div class= 'message'>
                    <p>Passwords do not match!</p>
                    </div><br>";
                    echo "<a href='javascript:self.history.back();'><button class='btn'>Go Back</button></a>";
                }
                else{
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    // Insert user into database
                    $insert_query = mysqli_query($con, "INSERT INTO users (Username, Email, Birth_date, PASSWORD, question1, question2, question3, Fname, Lname) VALUES ('$username', '$email', '$birth_date', '$hashed_password', '$question1', '$question2', '$question3', '$Fname', '$Lname')");
                    if($insert_query){
                        echo "<div class= 'message'>
                        <p>Registration successful! You can now <a href='index.php'>login</a>.</p>
                        </div>";
                    }
                    else{
                        echo "<div class= 'message'>
                        <p>Something went wrong! Please try again later.</p>
                        </div>";
                    }
                }
            }
        }
        ?>
        <header>Create a new account</header>
        <form action="" method="post">
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="field input">
                <label for="Fname">First Name</label>
                <input type="text" name="Fname" id="Fname" required>
            </div>
            <div class="field input">
                <label for="Lname">Last Name</label>
                <input type="text" name="Lname" id="Lname" required>
            </div>
            <div class="field input">
                <label for="Birth_date">Birth Date - (mm-dd-yyyy)</label>
                <input type="text" name="Birth_date" id="Birth_date" pattern="\d{2}-\d{2}-\d{4}" title="Please enter the date in the format mm-dd-yyyy" required>
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
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="field input">
                <label for="confirm_password">Confirm Password</label>
                <input type="confirm_password" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="field input">
                <input type="submit" name="submit" class='btn' value="Sign Up" required>
            </div>
            <div 
                class="g-recaptcha" data-sitekey="6Lfl-G0qAAAAAJNk_ExrsZD1iNeJbOTgOATwFGiB">
            </div>
            <div class="links">
                Already have an account? <a href="index.php">Sign In here</a>
            </div>
        </form>
    </div>
  </div>
</body>
</html>
