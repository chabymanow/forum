<?php
include_once "database.php";
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Define variables and initialize with empty values
$useremail = $password = $username = $userwebsite = "";
$username_err = $password_err = $login_err = $useremail_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter some username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if useremail is empty
    if(empty(trim($_POST["useremail"]))){
        $useremail_err = "Please enter useremail.";
    } else{
        echo "email";
        $check = $_POST["useremail"];
        $sql = "SELECT userEmail FROM users WHERE userEmail = '$check'";
        $stmt = mysqli_query($conn, $sql);
        $registered = mysqli_fetch_array($stmt, MYSQLI_NUM);
        if($registered > 0){
            $useremail_err = "This email address is in the system already";
        }else{
            $useremail = trim($_POST["useremail"]);
        }
        
    }

    if(empty($_POST["userwebsite"])){
        $userwebsite = "No website";
    }else{
        $userwebsite = $_POST["userwebsite"];
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
        $userPassword = password_hash($password, PASSWORD_DEFAULT);
    }
    
    // Validate credentials
        if(empty($username_err) && empty($password_err) && empty($useremail_err)){
            // Prepare a select statement
            $registerUser = mysqli_query($conn, "INSERT INTO users (userName, userEmail, password, website, registerDate) VALUES
            ('$username', '$useremail', '$userPassword', '$userwebsite', STR_TO_DATE(now(), '%Y-%m-%d %H:%i:%s'))");
            if($registerUser){
                $getRegisterData = mysqli_query($conn, "SELECT * FROM users WHERE userEmail='$useremail'");
                $userLogin = mysqli_fetch_array($getRegisterData);
                session_start();
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $userLogin["userID"];
                $_SESSION["useremail"] = $userLogin["userEmail"]; 
                $_SESSION["username"] = $userLogin["userName"];                    
                header("location: index.php");

            }
        }
    // Close connection
    mysqli_close($conn);
}
?>

<div class="flex flex-col h-screen">
  <?php include "header.php"; ?>
  <div class="flex justify-center min-h-[80%] h-[80%] flex-grow items-center">
    <div class="w-[20%] h-fit items-center bg-slate-200 rounded-2xl py-10 px-5 border-1 shadow-md">
      <!-- <form class="flex flex-col gap-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> -->
      <form class="flex flex-col gap-3" action="register.php" method="post">

        <h1 class="text-center text-4xl font-bold mb-8">Register</h1>

        <label for="username">Username</label>
        <span class="text-red-600 text-sm font-bold"> <?php echo $username_err;?></span>
        <input class="rounded-md" type="text" name="username" id="username">

        <label for="useremail">Email</label>
        <span class="text-red-600 text-sm font-bold"> <?php echo $useremail_err;?></span>
        <input class="rounded-md" type="text" name="useremail" id="useremail">

        <label for="userwebsite">Website</label>
        <span class="text-red-600 text-sm font-bold"> <?php echo $useremail_err;?></span>
        <input class="rounded-md" type="text" name="userwebsite" id="userwebsite">

        <label for="first_name">Password</label>
        <span class="text-red-600 text-sm font-bold"> <?php echo $password_err;?></span>
        <input class="rounded-md" type="password" name="password" id="password">

        <input class="submit px-4 py-2 text-stone-100 text-lg bg-gradient-to-br from-sky-600 to-sky-800 rounded-xl mt-3 cursor-pointer shadow-gray-900 shadow-md hover:text-stone-200 hover:font-semibold hover:shadow-sm hover:shadow-gray-700" type="submit" name="submit" value="Login" />

      </form>
    </div>
  </div>
  <?php @ require_once ("footer.php"); ?>
</div>