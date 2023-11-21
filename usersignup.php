<html> <head> <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head></html>
<?php
$userName= "";
$mobileNumber = ""; // Initialize mobileNumber variable
$email = ""; // Initialize email variable
$emailerror = ""; // Initialize emailerror variable
$mobileerror = ""; // Initialize mobileerror variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST["userName"];
    $mobileNumber = $_POST["mobileNumber"];
    $email = $_POST["email"];
   // $email="";


    if (empty($userName) || empty($mobileNumber) || empty($email)) {
        echo "All fields are required.";
    }
    
    
    elseif (strlen($mobileNumber) != 10) {
        ?>
                <script>
                    swal("Mobile number must be 10 digits long");
                </script>
                <?php
    }
    elseif (!preg_match('/^[A-Za-z]+$/', $userName)) {
        ?>
                <script>
                    swal("Name should only contain alphabetic characters");
                </script>
                <?php
    } 
    else {
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "dcme_web";

        $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if mobile number and email are unique in the database
        $checkQuery = "SELECT * FROM users WHERE mobileNumber = ? OR email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("ss", $mobileNumber, $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

//existing email verification and mobile verification
 
$verifyemail = "SELECT * FROM users WHERE email = '$email'";
    $resultemail = $conn->query($verifyemail);


    $verifymobile = "SELECT * FROM users WHERE mobileNumber = '$mobileNumber'";
    $resultmobile = $conn->query($verifymobile);
        

    if ($resultemail->num_rows > 0) {
        $emailerror = "This email already exists in the database.";
    } 
    elseif($resultmobile->num_rows>0)
    {$mobileerror="this mobile number already exists";

    }
            
            else {
            // Insert user data into the database
            $insertQuery = "INSERT INTO users (userName, mobileNumber, email) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("sss", $userName, $mobileNumber, $email);

            if ($insertStmt->execute()) {
                ?>
                <script>
                    swal({
                        title: "Joined Successfully!",
                        text: "You are a donor now!",
                        icon: "success"
                    });
                    
                </script>
                <?php
                 header("Location:website.html"); // Replace with your success page
                 exit();
            } else {
                ?>
                <script>
                    swal("An error occurred");
                </script>
                <?php
            }

            $insertStmt->close();
        }

        $checkStmt->close();
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Sign up Page</title>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        
        /* Styling for the entire page */
        body {
            font-family: Arial, sans-serif;
            /*background-color: #afdaa9; /* Background color of the entire page */
            /*display: flex;*/
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
           /* background-size: cover; /* Adjust the background size as needed */
 /* background-position: center; /* Center the background image */
            background-repeat: no-repeat;
          /*  background-image: url("\\example1\\HUNGRY_HEARTS\\hungry heartspics\\donorch.png");*/
        }

        /* Styling for the login container */
        .container {
            width: 400px;
            padding: 50px;
            margin-left: 850px;
            margin-top: 70px;
            margin-bottom: 50px;

            /*background-color: #318331; /* Light green background color */
            box-shadow: 0 0 10px rgba(199, 139, 139, 0.1);
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50px;
          
        }

        /* Styling for the side headings */
        .side-heading {
            background-color: #0fce28; /* Green background color for side headings */
            color: white; /* Text color for side headings */
            padding: 10px;
            text-align: center;
            border-radius: 50px;
        }

        /* Styling for form groups */
        .form-group {
            background-color: transparent; /* Remove background color for form fields */
            border-radius: 50px;

            margin-bottom: 15px; /* Increase distance between cells */
        }

        /* Styling for labels within form groups */
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        /* Styling for text input fields within form groups */
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 3px solid #575252; /* Darker border color for input fields */
            border-radius: 3px;
            color: #000; /* Text color for input fields */
        }

        /* Styling for the login button */
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #1b08bd; /* Blue background color for the button */
            color: #fff; /* Text color for the button */
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }
.sign  {
           width: 50%;
           padding: 20px; /* Increase button size */
           background-color: #1b08bd; /* Blue background color for the button */
           color: #fff; /* Text color for the button */
           border: none;
           border-radius: 50px 50px 50px 50px;
           cursor: pointer;
           display: block; /* Make the button a block-level element */
           margin: 0 auto; /* Center-align the button horizontally */
       }
      
        /*background-image: url("\\example\\HUNGRY_HEARTS\\hungry heartspics\\Screenshot (97).png");
       */
   /* background-color: #606990;*/
    </style>
      <link rel="stylesheet" href="\example1\HUNGRY_HEARTS\website\handF.css">
</head>
<body>

    <div class="container">
        <h2 class="side-heading">JOIN WITH US!</h2>
        <form action="usersignup.php" method="post">
            <div class="form-group">
                <label for="donorName">YOUR Name:</label>
                
                <input type="text" name="userName" placeholder="Enter your name " value="<?php echo $userName; ?>" required><br>
            </div>
            <div class="form-group">
                <!--<label for="mobileNumber">Mobile Number:</label>
                <input type="text" id="mobileNumber" name="mobileNumber" placeholder="Enter Mobile Number" required>
    -->
    <label for="mobileNumber">Mobile Number:</label>
    <input type="text" name="mobileNumber" placeholder="Enter Mobile Number" value="<?php echo $mobileNumber; ?>" required><br>
        <span style="color: red;"><?php echo $mobileerror; ?></span>
        
</div>
            <div class="form-group">
               <!-- <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
    --><label for="email">Email:</label>
    <input type="email" name="email" placeholder="Enter your email " value="<?php echo $email; ?>" required><br>
        <span style="color: red;"><?php echo $emailerror; ?></span>
        <br>
</div>
           <!-- <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter Address" required>
            </div>-->
           <!-- <div class="form-group">
                <label for="password">Create Password:</label>
                <input type="password" id="password" name="password" placeholder="Create Password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            </div>-->
            <button type="submit" class="sign">JOIN !</button>
             
       
        </form>
    </div>
   
</body>
</html>
 