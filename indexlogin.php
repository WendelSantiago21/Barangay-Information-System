<?php
$errors = array(); // Initialize an array to store errors
$login_message = ""; // Initialize login message variable
// Check if the form is submitted
if(isset($_POST['btnlogin'])){
    // Check if the username and password fields are empty
    if(empty($_POST['txtusername']) || empty($_POST['txtpassword'])) {
        $errors[] = "Please enter both username and password.";
    } else {
        sleep(1);
        // Require the config file
        require_once "config.php";
        // Build the template for the login SQL statement
        $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ? AND userstatus = 'ACTIVE'";
        // Check if the SQL statement will run on the link by preparing the statement
        if($stmt = mysqli_prepare($link, $sql)) {
            // Bind the data from the login form to the SQL statement
            mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
            // Check if the statement will execute
            if(mysqli_stmt_execute($stmt)) {
                // Get the result of executing the statement
                $result = mysqli_stmt_get_result($stmt);
                // Check if there is a result
                if(mysqli_num_rows($result) > 0) {
                    // Fetch the result into an array
                    $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    // Create a session
                    session_start();
                    // Record session
                    $_SESSION['username'] = $_POST['txtusername'];
                    $_SESSION['usertype'] = $account['usertype'];
                    // Redirect to the accounts page
                    header("location:index.php");
                } else {
                    $errors[] = "<strong><span style='color: red;'>Incorrect login details or account is disabled/inactive</span></strong>";
                }
            } else {
                $errors[] = "Error on the login statement";
            }
        }
    }

    // Check if login is successful before displaying the form
    if (!empty($errors)) {
        $login_message = implode("<br>", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - Barangay Information System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/logo1.svg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="indexlogin.css">
</head>
<body style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('brgy2.png'); background-repeat: no-repeat; height: 100vh; margin: 0; background-size: cover; background-position: center; background-repeat: no-repeat;">
<header class="header">
    <div class="header-container">
        <!-- Hamburger Menu Button (Visible on Small Screens) -->
        <button class="menu-toggle" onclick="toggleNav()">☰</button>

        <!-- Standard Navigation for Large Screens -->
		<h1 class="brand">Barangay Information System</h1>
        <nav class="top-nav">
            <ul>
                <li><a href="certificate_request.php" class="btn-slide"><span>Request for Certificate</span></a></li>
                <li><a href="request_clearance.php" class="btn-slide"><span>Request for Clearance</span></a></li>
                <li><a href="request_indigency.php" class="btn-slide"><span>Request for Indigency</span></a></li>
            </ul>
        </nav>

    </div>
</header>

<!-- Side Navigation (Initially Hidden) -->
<div id="sideNav" class="side-nav">
    <a href="javascript:void(0)" class="close-btn" onclick="closeNav()">×</a>
    <a href="certificate_request.php">Request for Certificate</a>
    <a href="request_clearance.php">Request for Clearance</a>
    <a href="request_indigency.php">Request for Indigency</a>
</div>
<script>
function toggleNav() {
    document.getElementById("sideNav").style.width = "250px";
    document.getElementById("overlay").style.display = "block"; // Show overlay
}

function closeNav() {
    document.getElementById("sideNav").style.width = "0";
    document.getElementById("overlay").style.display = "none"; // Hide overlay
}
</script>


    <style>
        .header-container {
            display: flex;
    align-items: center;
    justify-content: space-between; /* Adjust for small screens */
    padding: 10px 20px;
    background-color: #385494;
    position: relative;
    width: 100%;
        }
        .btn-slide {
            display: inline-block;
            position: relative;
            padding: 10px 20px;
            color: white;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            overflow: hidden;
            transition: 0.4s;
            border: 2px solid white;
        }
        .btn-slide::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: white;
            transition: 0.4s;
        }
        .btn-slide span {
            position: relative;
            z-index: 2;
        }
        .btn-slide:hover::before {
            left: 0;
        }
        .btn-slide:hover span {
            color: #333;
        }
        .top-nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    padding: 0;
    margin: 0;
}

.top-nav li {
    display: inline-block;
}

.top-nav a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 10px;
    transition: color 0.3s ease;
}

.top-nav a:hover {
    color: #00bcd4;
}

/* Hide Standard Navigation on Small Screens */
@media (max-width: 1500px) {
    .top-nav {
        display: none;
    }
}

/* Hamburger Menu Button */
.menu-toggle {
    background: none;
    border: none;
    font-size: 24px;
    color: white;
    cursor: pointer;
    display: none;
}

/* Show Hamburger Button on Small Screens */
@media (max-width: 1500px) {
    .menu-toggle {
        display: block;
        margin-left: auto;
        left: 50%;
        transform: translateX(-50%);
	animation: none !important;
    }
}

/* Side Navigation */
.side-nav {
    height: 100%;
    width: 0;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #335792;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* Align items to the left */
    z-index: 9999; /* This ensures it is on top */
}

.side-nav a {
    display: block;
    padding: 15px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    transition: 0.3s;
}

.side-nav a:hover {
    background-color: #1e407c;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 25px;
    font-size: 30px;
    color: white;
    cursor: pointer;
    z-index: 10000; /* Ensures close button is clickable */
}

/* Centering the Brand Title */
.brand {
    font-size: 24px;
    font-weight: bold;
    white-space: nowrap;
}

@media (max-width: 1500px) {
    .header-container {
        justify-content: center; /* Centers everything */
    }

    .brand {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
    }
}
		.footer {
			background-color: #4da8da;
		}
		.social-media{
			background-color: #4da8da;
		}
    </style>
    <div class="notification" id="notification"></div>
    <script>
    function displayNotification(message, type) {
        var notification = document.getElementById('notification');
        notification.style.display = 'block';
        notification.innerHTML = '<div class="notification-content">' +
            '<div class="notification-icon ' + type + '"></div>' +
            '<div class="notification-message">' + message + '</div>' +
            '</div>';
        setTimeout(function() {
            notification.style.display = 'none';
        }, 3000);
    }

    // Ensure the message is displayed only once
    document.addEventListener("DOMContentLoaded", function () {
        let storedMessage = localStorage.getItem("formSubmitted");
        if (storedMessage) {
            displayNotification(storedMessage, "success");
            localStorage.removeItem("formSubmitted"); // Clear message immediately after displaying
        }
    });

    <?php
    if (!empty($login_message)) {
        echo "setTimeout(function() { displayNotification('<b>" . addslashes($login_message) . "</b>', 'error'); }, 500);";
    }
    ?>
</script>

    <div class="login-container">
        <div class="login-box">
            <div class="colorful-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
            <div class="overlay"></div>
            <div class="inner-overlay"></div>
            <div class="glow"></div>
            <div class="glow-2"></div>
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="login-form">
            <h2>ENTER USERNAME:</h2>
                <div class="input-field">
                    <input type="text" id="txtusername" name="txtusername" required>
                    <label for="txtusername">Username</label>
                    <div class="bar"></div>
                </div>
                <h2>ENTER PASSWORD:</h2>
                <div class="input-field">
                    <input type="password" id="txtpassword" name="txtpassword" required>
                    <label for="txtpassword">Password</label>
                    <div class="bar"></div>
                </div><br><br>
                <div id="showPasswordContainer">
                    <input type="checkbox" id="showPassword">
                    <label class="toggle-switch" for="showPassword"></label>
                    <label style="color:black;font-weight:bolder;" for="showPassword" id="passwordText">Show Password</label>
                </div><br><br>
                <input type="submit" class="btnlogin" name="btnlogin" value="Login">
                <div class="animated-squares">
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                    <div class="square"></div>
                </div>
                <div class="colorful-circles">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                <div class="rotating-triangles">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
            </form>
            <div class="php-errors"></div>
        </div>
    </div>
	
    <script>
        document.querySelector('.btnlogin').addEventListener('click', function(event) {
            var btn = event.target;
            var form = document.getElementById('login-form');
            var phpErrors = form.querySelector('.php-errors'); 
            if (form.checkValidity()) {
                btn.value = "please wait Logging in...";
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.7';
                
                setTimeout(function() {
                    btn.value = "Login";
                    btn.style.pointerEvents = 'auto';
                    btn.style.opacity = '1';
                    
                    form.submit();
                }, 5000);
            } else {
                event.preventDefault();
                
                phpErrors.innerHTML = "";
                
                var errorMessage = document.createElement('span');
                errorMessage.style.color = 'red';
                errorMessage.textContent = "Please fill up the form completely.";
                phpErrors.appendChild(errorMessage);
            }
        });

        document.getElementById("showPassword").addEventListener("change", function() {
            var passwordField = document.getElementById("txtpassword");
            var passwordText = document.getElementById("passwordText");
            if (this.checked) {
                passwordField.type = "text";
                passwordText.textContent = "Hide Password";
            } else {
                passwordField.type = "password";
                passwordText.textContent = "Show Password";
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var passwordField = document.getElementById("txtpassword");
            passwordField.type = "password";
            var passwordText = document.getElementById("passwordText");
            passwordText.textContent = "Show Password";
        });
    </script>
    <footer class="footer">
	<div class="social-media">
        <a href="#"><img src="img/facebook.svg" alt="Facebook"></a>
        <a href="#"><img src="img/twitter.svg" alt="Twitter"></a>
        <a href="#"><img src="img/instagram.svg" alt="Instagram"></a>
    </div>
    <div class="footer-menu">
        <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
        </ul>
    </div>
</footer>
</body>
</html>