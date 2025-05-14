<?php
require_once "config.php";
require_once "session-checker.php";

$Username = $_SESSION['username'];
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Database connection (modify with your database credentials)
$host = "localhost"; // Change if your database is hosted elsewhere
$user = "root"; // Default XAMPP user
$password = ""; // Default XAMPP password (leave empty if none)
$database = 'itc127-2b-2024';
$conn = $link;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected letter
$letter = isset($_GET['letter']) ? $_GET['letter'] : 'A';
// Fetch residents with names starting with the selected letter
$sql = "SELECT id, first_name, last_name FROM tblresidents WHERE first_name LIKE '$letter%' ORDER BY first_name";
$result = $conn->query($sql);

// Fetch resident details if an ID is selected
$residentDetails = null;
if (isset($_GET['resident_id'])) {
    $resident_id = intval($_GET['resident_id']);
    $sqlDetails = "SELECT * FROM tblresidents WHERE id = $resident_id";
    $residentDetails = $conn->query($sqlDetails)->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Records</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #a6a6ff;
            margin: 0;
            padding: 0;
        }
		.topnav {
    overflow: hidden;
    background-color: #1F2833;
    font-weight:bold;
    color:white;
	display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Push brand to the left and username to the right */
    width: 100%;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.topnav .dropdown {
    float: left;
    overflow: hidden;
}

.topnav .dropdown .dropbtn {
    display: block;
    color: #ffffff;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
.topnav .dropdown .dropdown-content {
    display: none;
    position: absolute;
    background-color: #333;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.topnav .dropdown:hover .dropdown-content {
    display: block;
}
        .Welcome {
    background-color: #335792;
    padding: 10px;
    text-align: center;
    margin-bottom: 18px;
}
        .container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid black;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 8px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 9px 0;
        }
        .stats div {
            background: #ffff99;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid black;
        }
        .menu {
            padding: 10px;
            background: lightblue;
            border-right: 2px solid black;
            width: 200px;
            float: left;
            height: 100vh;
        }
        .menu a {
            display: block;
            text-decoration: none;
            color: blue;
            margin: 10px 0;
            font-size: 16px;
        }
        .roles-container {
            margin-left: 220px;
            display: flex;
            justify-content: space-between;
        }
        .roles {
            width: 45%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .roles label {
            display: flex;
            flex-direction: column;
            width: 100%;
            font-size: 16px;
            margin: 10px 0;
        }
        .roles input {
            margin-top: 5px;
        }
        .roles img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-top: 5px;
            border: 1px solid black;
            display: none;
        }
        .save-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .save-button:hover {
            background-color: darkgreen;
        }
		body {
            font-family: 'Montserrat', sans-serif;
            background-color: beige;
            margin: 0;
            padding: 0;
        }
        
.topnav {
    overflow: hidden;
    background-color: #1F2833;
    font-weight:bold;
    color:white;
	display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Push brand to the left and username to the right */
    width: 100%;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
.topnav .dropdown {
    float: left;
    overflow: hidden;
}

.topnav .dropdown .dropbtn {
    display: block;
    color: #ffffff;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
.topnav .dropdown .dropdown-content {
    display: none;
    position: absolute;
    background-color: #333;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.topnav .dropdown:hover .dropdown-content {
    display: block;
}
        .Welcome {
    background-color: #335792;
    padding: 10px;
    text-align: center;
    margin-bottom: 18px;
}
.logo {
    position:absolute;
    top: 10px;
    right: 0;
    width: 50px;
    height: 80px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 420px;
}
.stulogo {
    position:absolute;
    top:0;
    right: 0;
    width: 50px;
    height: 80px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 530px;
}

.Welcome h1 {
    color: #ffffff;
    font-size: 18px;
    margin-top: 5px;
}

.Welcome a {
    display: inline-block;
    background-color: #ff6f61;
    color: #ffffff;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.Welcome a:hover {
    background-color: #ff5440;
}
.reglogo {
    position:absolute;
    top: 10px;
    right: 0;
    width: 50px;
    height: 60px;
    background-image: url('./img/logo1.svg');
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 50%;
    margin-right: 460px;
}
.notification {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #ffffff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.profile-picture-container {
position: absolute;
top: 5px;
right: 80px;
}
.regprofile-picture-container {
position: absolute;
top: 0px;
right: 50px;
margin-bottom:5px;
}
.profile-picture {
width: 70px;
height: 70px;
border-radius: 50%;
margin-bottom:10px;
object-fit: cover;
border:none;
box-shadow:none;
}

.profile-info {
    color: #333;
}

.profile-info h1 {
    font-size: 24px;
    margin-bottom: 5px;
}

.profile-info h4 {
    font-size: 16px;
    margin-bottom: 10px;
}

.profile-actions {
    margin-left: auto;
}

.profile-actions a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
    margin-top: 10px;
}

.profile-actions a:hover {
    color: #1e87cd;
}
.profile-picture-container {
    position: absolute;
    top: 5px;
    right: 40px;
}
.regprofile-picture-container {
    position: absolute;
    top: 0px;
    right: 40px;
    margin-bottom:5px;
}
.stuprofile-picture-container {
    position: absolute;
    top: 0px;
    right: 50px;
    margin-bottom:10px;
}
.stuprofile-picture {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom:10px;
    object-fit: cover;
    border:none;
    box-shadow:none;
}
.username {
    color: white;
    font-size: 18px;
    margin-right: 30px; 
}
.stuusername {
    color: white;
    font-size: 18px;
    margin-left: 1280px; 
    display: inline-block;
}
.regusername {
    color: white;
    font-size: 18px;
    margin-left: 790px; 
    display: inline-block;
}

.footer {
    text-align: center;
    font-size: 1rem;
    font-weight: bold;
    background-color: #2596be;
	position: fixed;
    left: 0;
    bottom: 0; 
    width: 100%;
}
.footer ul {
    list-style: none;
	padding: 0;
    text-align: center; /* Centers the list items */
    display: flex;
    justify-content: center; /* Centers horizontally */
    gap: 20px; /* Adds spacing between items */
}

.footer ul li {
    display: inline-block;
}
.footer ul li a {
    color: black;
    text-decoration: none;
    margin-bottom: 50px;
}
.social-media {
    text-align: center;
    margin-top: 20px;
    padding-top: 10px;
    background-color: #2596be;
	display: flex;
    justify-content: center; /* Centers the icons */
    gap: 20px; /* Ensures equal spacing between icons */
    margin-bottom: 20px; /* Adds some spacing before other footer content */
}
.social-media img {
    width: 30px;
    height: 30px;
    transition: transform 0.3s ease;
}

.social-media img:hover {
    transform: scale(1.2);
}
.hamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:70px; 
}
.reghamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:40px; 
}
.stuhamburger-icon {
    font-size: 18px;
    color: white; 
    border-radius: 50%;
    padding: 6px;
    position: absolute;
    bottom:25px;
    right:40px; 
}
.hero {
      text-align: center;
      padding: 150px 0;
      background: linear-gradient(45deg, #ff8a00, #e52e71);
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: -1;
      animation: heroAnimation 15s infinite alternate;
    }

    @keyframes heroAnimation {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.05);
      }
    }

    .hero-content {
      opacity: 0;
      animation: fadeInUp 1s forwards 0.5s;
    }

    .hero-heading {
      font-size: 72px;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
      animation-timing-function: ease-out;
    }

    .hero-text {
      font-size: 24px;
      margin-bottom: 30px;
      animation: fadeInUp 1s forwards 1.1s;
      animation-timing-function: ease-out;
    }

    .btn {
      display: inline-block;
      background-color: #fff;
      color: #ff8a00;
      padding: 15px 30px;
      border-radius: 50px;
      text-decoration: none;
      font-size: 24px;
      transition: background-color 0.3s ease;
      animation: fadeInUp 1s forwards 1.4s;
    }

    .btn:hover {
      background-color: #e05244;
    }

    .features {
      padding: 150px 0;
      background-color: #f9f9f9;
      transition: background-color 0.5s ease;
    }

    .features-heading {
      text-align: center;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2s;
      transition: color 0.5s ease;
    }

    .feature {
      text-align: center;
      margin-bottom: 50px;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      animation: fadeInUp 1s forwards;
      position: relative;
      background-color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .feature:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
    }

    .feature-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 20px;
      z-index: -1;
      opacity: 0;
      animation: featureAnimation 1s forwards;
    }

    @keyframes featureAnimation {
      0% {
        opacity: 0;
        transform: scale(1);
      }
      100% {
        opacity: 1;
        transform: scale(1.02);
      }
    }

    .feature-image {
      width: 200px;
      border-radius: 50%;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
    }

    .feature-content {
      position: relative;
      z-index: 1;
      animation: fadeInUp 1s forwards 1s;
    }

    .feature-heading {
      margin-top: 20px;
      font-size: 28px;
      color: black;
      animation: fadeInUp 1s forwards 1.2s;
    }

    .feature-text {
      font-size: 18px;
      color: black;
      animation: fadeInUp 1s forwards 1.4s;
    }

    footer {
      background-color: #222;
      color: #fff;
      text-align: center;
      animation: fadeIn 1s forwards 3s;
    }

    .footer-links {
      list-style-type: none;
      margin-top: 20px;
    }

    .footer-links-item {
      display: inline-block;
      margin-left: 10px;
      animation: fadeIn 1s forwards 3.2s;
    }

    .footer-link {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
      font-size: 18px;
    }

    .footer-link:hover {
      color: #ff6f61;
    }

    @keyframes fadeInUp {
      0% {
        transform: translateY(50px);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeInLeft {
      0% {
        opacity: 0;
        transform: translateX(-50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
       0% {
        opacity: 0;
        transform: translateX(50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }
    .feature:nth-child(odd) {
      background-color: #f3f3f3;
    }

    .feature:nth-child(even) {
      background-color: #eaeaea;
    }

    .feature-overlay {
      background: rgba(255, 255, 255, 0.3);
    }

    .feature:hover .feature-overlay {
      background: rgba(255, 255, 255, 0.5);
    }

    .feature-image {
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .feature-heading {
      color: #ff6f61;
      font-size: 32px;
      margin-top: 30px;
    }

    .feature-text {
      color: #444;
      font-size: 16px;
      line-height: 1.6;
    }

    footer {
      margin-top: 100px;
    }

    @media screen and (max-width: 768px) {
      .container {
        padding: 0 15px;
      }

      .logo {
        font-size: 24px;
      }

      .navigation {
        flex-direction: column;
        align-items: center;
      }

      .navigation-item {
        margin-left: 0;
        margin-bottom: 10px;
      }

      .hero-heading {
        font-size: 48px;
      }

      .hero-text {
        font-size: 20px;
      }

      .btn {
        padding: 12px 24px;
        font-size: 20px;
      }

      .feature-heading {
        font-size: 24px;
      }

      .feature-text {
        font-size: 14px;
      }
    }

    .animated-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackground 10s linear infinite;
    }

    @keyframes animatedBackground {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    .animated-text {
      position: relative;
      display: inline-block;
      animation: glitch 1s infinite;
    }

    @keyframes glitch {
      0% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
      25% {
        transform: translateY(-5px) translateZ(0);
      }
      50% {
        transform: translateY(0) translateZ(0);
        opacity: 0.7;
      }
      75% {
        transform: translateY(5px) translateZ(0);
      }
      100% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
    }

    .animated-border {
      position: relative;
      display: inline-block;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 2px solid transparent;
      z-index: -1;
      transition: all 0.3s ease;
    }

    .animated-border::before {
      border-top-color: #ff8a00;
      border-right-color: #e52e71;
    }

    .animated-border::after {
      border-bottom-color: #ff8a00;
      border-left-color: #e52e71;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      border-color: transparent;
    }
    .fadeIn {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fadeInDelay {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 0.5s;
    }

    .fadeInDelayTwo {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 1s;
    }
    .cta-section {
      text-align: center;
      padding: 100px 0;
      background-color: #222;
      color: #fff;
    }

    .cta-heading {
      font-size: 48px;
      margin-bottom: 30px;
      animation: fadeIn 1s forwards 2s;
    }

    .cta-text {
      font-size: 24px;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2.5s;
    }

    .cta-btn {
      display: inline-block;
      background-color: #ff6f61;
      color: #fff;
      padding: 15px 30px;
      border-radius: 50px;
      text-decoration: none;
      font-size: 24px;
      transition: background-color 0.3s ease;
      animation: fadeIn 1s forwards 3s;
    }

    .cta-btn:hover {
      background-color: #e05244;
    }

    .animation-wrapper {
      position: relative;
      overflow: hidden;
    }

    .animated-feature {
      position: relative;
      z-index: 1;
    }

    .animation-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 20px;
      z-index: -1;
      opacity: 0;
      animation: fadeInOverlay 1s forwards;
    }

    @keyframes fadeInOverlay {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    .animated-feature:hover .animation-overlay {
      background: rgba(255, 255, 255, 0.5);
    }

    .animation-image {
      width: 150px;
      border-radius: 50%;
      margin-bottom: 20px;
      animation: fadeInUp 1s forwards 0.8s;
    }

    .animation-heading {
      font-size: 28px;
      margin-top: 20px;
      animation: fadeInUp 1s forwards 1s;
    }

    .animation-text {
      font-size: 18px;
      color: #ccc;
      animation: fadeInUp 1s forwards 1.2s;
    }
    .body-section {
      padding: 100px 0;
    }

    .body-heading {
      font-size: 42px;
      text-align: center;
      margin-bottom: 50px;
      animation: fadeIn 1s forwards 2s;
    }

    .body-text {
      font-size: 18px;
      line-height: 1.8;
      margin-bottom: 30px;
      animation: fadeIn 1s forwards 2.5s;
    }

    .body-image {
      width: 100%;
      max-width: 600px;
      display: block;
      margin: 0 auto;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      animation: fadeInUp 1s forwards 3s;
    }

    .body-image:hover {
      transform: scale(1.05);
    }

    .body-quote {
      font-size: 24px;
      font-style: italic;
      text-align: center;
      margin-top: 30px;
      animation: fadeIn 1s forwards 3.5s;
    }

    .body-author {
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      animation: fadeIn 1s forwards 4s;
    }
     @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInLeft {
      0% {
        opacity: 0;
        transform: translateX(-50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
      0% {
        opacity: 0;
        transform: translateX(50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInDown {
      0% {
        opacity: 0;
        transform: translateY(-50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInOverlay {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes glitch {
      0% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
      25% {
        transform: translateY(-5px) translateZ(0);
      }
      50% {
        transform: translateY(0) translateZ(0);
        opacity: 0.7;
      }
      75% {
        transform: translateY(5px) translateZ(0);
      }
      100% {
        transform: translateY(0) translateZ(0);
        opacity: 1;
      }
    }

    @keyframes animatedBackground {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    @keyframes featureAnimation {
      0% {
        opacity: 0;
        transform: scale(1);
      }
      100% {
        opacity: 1;
        transform: scale(1.02);
      }
    }

    @keyframes heroAnimation {
      0% {
        transform: scale(1);
      }
      100% {
        transform: scale(1.05);
      }
    }

    @keyframes animatedBackgroundTwo {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100% -100%;
      }
    }

    @keyframes animatedBackgroundThree {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: 100% 100%;
      }
    }

    @keyframes animatedBackgroundFour {
      0% {
        background-position: 0 0;
      }
      100% {
        background-position: -100% 100%;
      }
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animated-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackground 10s linear infinite;
    }

    .animated-bg-two {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundTwo 10s linear infinite;
    }

    .animated-bg-three {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundThree 10s linear infinite;
    }

    .animated-bg-four {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(-45deg, rgba(255, 138, 0, 0.5), rgba(229, 46, 113, 0.5));
      transform: skewY(-10deg);
      z-index: -2;
      animation: animatedBackgroundFour 10s linear infinite;
    }

    .animated-text {
      position: relative;
      display: inline-block;
      animation: glitch 1s infinite;
    }

    .animated-border {
      position: relative;
      display: inline-block;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 2px solid transparent;
      z-index: -1;
      transition: all 0.3s ease;
    }

    .animated-border::before {
      border-top-color: #ff8a00;
      border-right-color: #e52e71;
    }

    .animated-border::after {
      border-bottom-color: #ff8a00;
      border-left-color: #e52e71;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      border-color: transparent;
    }
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay:hover {
      opacity: 1;
    }
    .expandable {
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .expandable:hover {
      transform: scale(1.1);
    }

    .clickable {
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .clickable:hover {
      background-color: #ddd;
    }

    .hoverable {
      transition: transform 0.3s ease;
    }

    .hoverable:hover {
      transform: translateY(-5px);
    }

    .focusable {
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .focusable:focus {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .blink {
      animation: blinkAnimation 1s infinite;
    }

    @keyframes blinkAnimation {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
    @keyframes slideInFromLeft {
      0% {
        transform: translateX(-100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromRight {
      0% {
        transform: translateX(100%);
        opacity: 0;
      }
      100% {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromTop {
      0% {
        transform: translateY(-100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes slideInFromBottom {
      0% {
        transform: translateY(100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes rotateIn {
      0% {
        transform: rotate(-180deg);
        opacity: 0;
      }
      100% {
        transform: rotate(0deg);
        opacity: 1;
      }
    }

    @keyframes bounce {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0);
      }
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
      100% {
        transform: scale(1);
      }
    }

    @keyframes shake {
      0% {
        transform: translateX(0);
      }
      25% {
        transform: translateX(-10px);
      }
      50% {
        transform: translateX(10px);
      }
      75% {
        transform: translateX(-5px);
      }
      100% {
        transform: translateX(0);
      }
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    @keyframes fadeOut {
      0% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }
    .animated-border {
      position: relative;
      display: inline-block;
      overflow: hidden;
    }

    .animated-border::before,
    .animated-border::after {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      background-color: #ff8a00;
      width: 0%;
      transition: width 0.3s ease;
    }

    .animated-border::before {
      left: 0;
    }

    .animated-border::after {
      right: 0;
    }

    .animated-border:hover::before,
    .animated-border:hover::after {
      width: 100%;
    }

    .animated-text {
      position: relative;
      display: inline-block;
      overflow: hidden;
    }

    .animated-text::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, #ff8a00, transparent);
      animation: slideInFromRight 1s infinite;
    }

    .animated-text:hover::after {
      left: 100%;
      animation: slideInFromLeft 1s infinite;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .overlay:hover {
      opacity: 1;
    }

    .expandable {
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .expandable:hover {
      transform: scale(1.1);
    }

    .clickable {
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .clickable:hover {
      background-color: #ddd;
    }

    .hoverable {
      transition: transform 0.3s ease;
    }

    .hoverable:hover {
      transform: translateY(-5px);
    }

    .focusable {
      outline: none;
      transition: box-shadow 0.3s ease;
    }

    .focusable:focus {
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .blink {
      animation: blinkAnimation 1s infinite;
    }

    @keyframes blinkAnimation {
      0% {
        opacity: 1;
      }
      50% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
    .transition {
      transition: all 0.3s ease;
    }

    .transition:hover {
      transform: scale(1.1);
    }

    .fadeInDelay {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 0.5s;
    }

    .fadeInDelayTwo {
      opacity: 0;
      animation: fadeInAnimation 1s forwards;
      animation-delay: 1s;
    }
    .rainbow-text {
      background: linear-gradient(to right, #ff8a00, #ffbd00, #fff200, #b2ff00, #00ff6d, #00ffea, #00b2ff, #006dff, #4700ff, #a300ff, #e100ff, #ff00c8);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: rainbowAnimation 10s linear infinite;
    }

    @keyframes rainbowAnimation {
      0% {
        background-position: 0% 50%;
      }
      100% {
        background-position: 100% 50%;
      }
    }

    .floating {
      animation: floatingAnimation 3s ease-in-out infinite;
    }

    @keyframes floatingAnimation {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0);
      }
    }

    .zoom {
      transition: transform 0.5s ease;
    }

    .zoom:hover {
      transform: scale(1.1);
    }
	.brand {
    font-size: 24px;
    font-weight: bold;
    align items: center;
}
.container h2{
	text-align: center;
}
#requestSearchBar {
  display: flex;
  justify-content: flex-start; /* aligns to the left */
  align-items: center;
  margin: 20px;
  gap: 10px;
}
#requestSearchInput {
  padding: 10px;
  font-size: 16px;
  width: 500px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

#requestSearchBtn {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#requestSearchBtn:hover {
  background-color: #45a049;
}
.mytabs{
	display: flex;
	flex-wrap: wrap;
	max-width: 100%;
}
.mytabs input[type="radio"]{
	display: none;
}
.mytabs label{
	padding: 25px;
	background: white;
	font-weight: bold;
}
.mytabs .tab{
	width: 100%;
	padding: 20px;
	background: #b5c0fa;
	order: 1;
	display: none;
	border-radius: 0px 0px 10px 10px;
}
.tab{
	height: 390px;
	border: 1px solid #6e93f5
}
.tab h2{
	font-size: 25px;
}
.mytabs input[type='radio']:checked + label + .tab{
	display: block;
}
.mytabs input[type='radio']:checked + label{
	background: #faf97c ;
}
.view-link-certificate{
text-decoration: none;
height: 40px;
width: 100px;
background-color: white;
padding: 5px;
border-radius: 5px;
border: 1px solid gray;
background-color: #BDDDE4;
}
.view-link-indigency{
text-decoration: none;
height: 40px;
width: 100px;
background-color: white;
padding: 5px;
border-radius: 5px;
border: 1px solid gray;
background-color: #BDDDE4;
}
.view-link:hover{
background-color: #F4F8D3;
color: black;
}
.view-link-certificate:hover{
background-color: #F4F8D3;
color: black;
}
.view-link-indigency:hover{
background-color: #F4F8D3;
color: black;
}
.search1{
margin-left: -15px;
}
</style>
</head>
<header>
    <nav class="topnav" id="mytopnav">
        <?php if ($Usertype === 'ADMINISTRATOR'): ?>
		<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<a href="index.php">Home</a>
        <a href="brgy-dashboard.php">Dashboard</a>
        <a href="resident-records.php">Resident Records</a>
        <a href="new-resident.php">New <br>Resident</a>
		<a href="activity-records.php">Activity <br>Records</a>
		<a href="request-records.php">Request <br>Records</a>
		<a href="indexlogout.php">Logout</a>
		</div>
		<span style="font-size:30px;cursor:pointer;position:fixed;margin-left:20px;" onclick="openNav()">&#9776;</span>
		<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
            <div class="welcome">
            <div class=""></div>
            </div>
            <h3 style="margin-left:100px;margin-bottom:25px" class="brand"><strong>Barangay Information System</strong></h3>
            <div class="username"><?php echo $_SESSION['username']; ?></div>
			
        <?php elseif ($Usertype === 'REGISTRAR' || $Usertype === 'STAFF'): ?>
        <div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<a href="index.php">Home</a>
        <a href="Dashboard.php">Dashboard</a>
        <a href="resident-records.php">Resident Records</a>
        <a href="#">New <br>Resident</a>
		<a href="#">Activity <br>Records</a>
		<a href="#">Request <br>Records</a>
		<a href="indexlogout.php">Logout</a>
		</div>
		
		<span style="font-size:30px;cursor:pointer;position:fixed;margin-left:20px;" onclick="openNav()">&#9776;</span>
		<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
            <div class="welcome">
            <div class=""></div>
            </div>
            <h3 style="margin-left:100px;margin-bottom:25px" class="brand"><strong>Barangay Information System</strong></h3>
            <div class="username"><?php echo $_SESSION['username']; ?></div>
			
        <?php else: ?>
            <div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<a href="index.php">Home</a>
        <a href="Dashboard.php">Dashboard</a>
        <a href="resident-records.php">Resident Records</a>
        <a href="#">New <br>Resident</a>
		<a href="#">Activity <br>Records</a>
		<a href="#">Request <br>Records</a>
		<a href="indexlogout.php">Logout</a>
		</div>
		<span style="font-size:30px;cursor:pointer;position:fixed;margin-left:20px;" onclick="openNav()">&#9776;</span>
		<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
            <div class="welcome">
                <div class=""></div>
            </div>
            <h3 style="margin-left:100px;margin-bottom:25px" class="brand"><strong>Barangay Information System</strong></h3>
            <div class="username"><?php echo $_SESSION['username']; ?></div>
        <?php endif; ?>
    </nav>
</header>
    <body>
    <div class="container">
        <h2>Request Records</h2>
        <div id="requestSearchBar">
    <input type="text" id="requestSearchInput" class="search1" placeholder="Search by name or request type..."/>
    <button id="requestSearchBtn">Search</button>
</div>
		<script>
  document.getElementById("requestSearchBtn").addEventListener("click", function () {
    const query = document.getElementById("requestSearchInput").value.toLowerCase();
    
    // Implement your filtering logic here
    // Example: filter elements that match the query (e.g. search names or request types)
    console.log("Searching for:", query);
  });
</script>
	<div class="mytabs">
		<input type="radio" id="tabcertificate" name="mytabs" checked="checked">
		<label for="tabcertificate">Request Certificate</label>
		<div class="tab">
			<h2>REQUEST CERTIFICATE</h2>
      <?php
require_once 'config.php'; // Just connect, don't close yet

$sql = "SELECT id, name, age, address, status, purpose FROM tblcertificate ORDER BY id DESC";
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0):
?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Status</th>
                <th>Purpose</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="certificateTable">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr class="request-row" data-name="<?= strtolower($row['name']) ?>" data-type="certificate">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td>
                        <a href="view_request_certificate.php?id=<?= $row['id'] ?>" class="view-link-certificate">
                            View Request
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php
else:
    echo '<p>No certificate requests found.</p>';
endif;
?>
<!-- Modal Elements -->
<div id="overlay" onclick="closeModalCertificate()"></div>
<div id="requestModal">
    <div id="modalContentCertificate"></div>
    <button class="btn" onclick="printModalCertificate()">Print</button>
    <button class="btn" onclick="closeModalCertificate()">Close</button>
</div>

<script>
function openModalCertificate(data) {
  let currentCertificateRowId = null;

  const today = new Date();
    const options = { month: 'long' };
    const month = today.toLocaleDateString('en-US', options);
    const day = today.getDate();
    const year = today.getFullYear();
    const formattedDate = `${month} day of ${day}, ${year}`;


    let content = `
        <div style="display: flex; flex-direction: column; font-family: 'Times New Roman', serif; padding: 10px; width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <img src="logo.png" alt="Left Logo" style="height: 80px;">
                <div style="text-align: center; flex: 1;">
                    <div style="font-size: 14px;">REPUBLIC OF THE PHILIPPINES</div>
                    <div style="font-size: 16px; font-weight: bold;">BARANGAY 489 ZONE 48 DISTRICT IV</div>
                    <div style="font-size: 14px;">OFFICE OF THE PUNONG BARANGAY</div>
                </div>
                <img src="blogo.png" alt="Right Logo" style="height: 80px;">
            </div>

            <div style="display: flex; margin-top: 20px;">
                <div style="width: 30%; border-right: 1px solid #000; padding-right: 10px; font-size: 14px;">
                    <p><strong>Hon. Romeo V. Landicho</strong><br>Chairman</p>
                    <p>Ariel C. Raiola</p>
                    <p>Joseph G. Luna</p>
                    <p>Josephine M. Magat</p>
                    <p>Luisito T. De Mesa</p>
                    <p>Edward Carlo R. Bragais</p>
                    <p>Marlon V. Buen</p>
                    <p>Virginia L. Ferrer<br><em>– Councilman –</em></p>
                    <p>Julie Ann M. Luna<br><em>– SK Chairwoman –</em></p>
                    <p>Jayvee V. Marquez<br><em>Secretary</em></p>
                    <p>Cesaria R. Bragais<br><em>Treasurer</em></p>
                    <p style="margin-top: 20px; font-size: 12px;">1280 Carola Street Sampaloc, Manila<br><em>– Barangay Address –</em></p>
                </div>

                <div style="width: 72.5%; padding-left: 20px; font-size: 15px;">
                    <h2 style="text-align: center;">CERTIFICATE</h2>
                    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
                    <p>
                        This is to certify that Mr./Ms. <strong>${data.name}</strong> is a bonafide resident of Barangay 489 Zone 48 District IV,
                        with postal address <strong>${data.address}</strong>, Sampaloc Manila.
                    </p>
                    <p>This certification is being issued upon the request of the above-mentioned name for:</p>

                    <p style="margin-left: 20px;"><strong>( ✔ ) ${data.purpose}</strong></p>

                    <p>
                        Further certify that the above mentioned is a person with good moral character, and no criminal or civil case in this Barangay.
                    </p>

                    <p>
                        IN WITNESS WHEREOF I have here unto set my hand and affixed the official seal of this office.
                         Done in the city of Manila, this <strong>${formattedDate}</strong>.
                    </p>

                    <div style="text-align: center; margin-top: 60px;">
                        <p><strong>ROMEO V. LANDICHO</strong><br>PUNONG BARANGAY</p>
                    </div>

                    <div style="margin-top: 30px; font-size: 12px; border-top: 1px solid #000; padding-top: 10px;">
                        <strong>PROVISIONS and CONDITIONS</strong><br>
                        This Certification/Clearance may be canceled or revoked anytime should the public safety and interest so demand and upon engagement in illegal transactions.
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById("modalContentCertificate").innerHTML = content;
    document.getElementById("requestModal").style.display = 'block';
    document.getElementById("overlay").style.display = 'block';
}

function closeModalCertificate() {
    document.getElementById("requestModal").style.display = 'none';
    document.getElementById("overlay").style.display = 'none';
}

function printModalCertificate() {
    const printContents = document.getElementById("modalContentCertificate").innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    // Remove the specific printed row
    if (currentCertificateRowId) {
        currentCertificateRowId.remove();
        currentCertificateRowId = null;
    }

    closeModalCertificate(); // Optional: just to be sure it’s closed
}


// View certificate links
document.querySelectorAll('.view-link-certificate').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const row = this.closest('tr');
        currentCertificateRowId = row; // Save the row for removal later

        fetch(this.href)
            .then(res => res.json())
            .then(data => {
                if (!data.error) {
                    openModalCertificate(data);
                } else {
                    alert(data.error);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch data.");
            });
    });
});

</script>

		</div>
		<input type="radio" id="tabindigency" name="mytabs">
		<label for="tabindigency">Request Indigency</label>
		<div class="tab">
			<h2>REQUEST INDIGENCY</h2>
      <?php
require_once 'config.php'; // Make sure this only CONNECTS, not closes

$sql = "SELECT id, name, age, address, status, purpose FROM tblindigency ORDER BY id DESC";
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0):
?>
    <table>
        <thead>
        <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Status</th>
                <th>Purpose</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="indigencyTable">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr class="request-row" data-name="<?= strtolower($row['name']) ?>" data-type="indigency">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td>
                        <a href="view_request_indigency.php?id=<?= $row['id'] ?>" class="view-link-indigency">
                            View Request
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php
else:
    echo '<p>No indigency requests found.</p>';
endif;
 // ✅ Only close after everything is done
?>


<!-- Modal Elements -->
<div id="indigencyOverlay" onclick="closeModalIndigency()"></div>
<div id="indigencyModal">
    <div id="indigencyContent"></div>
    <button class="btn" onclick="printModalIndigency()">Print</button>
    <button class="btn" onclick="closeModalIndigency()">Close</button>
</div>

<script>
function openModalIndigency(data) {
    let currentIndigencyRow = null;

    const today = new Date();
    const options = { month: 'long' };
    const month = today.toLocaleDateString('en-US', options);
    const day = today.getDate();
    const year = today.getFullYear();
    const formattedDate = `${month} day of ${day}, ${year}`;

    let content = `
        <div style="display: flex; flex-direction: column; font-family: 'Times New Roman', serif; padding: 10px; width: 100%;">
            <!-- Header with logos -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <img src="logo.png" alt="Left Logo" style="height: 80px;">
                <div style="text-align: center; flex: 1;">
                    <div style="font-size: 14px;">REPUBLIC OF THE PHILIPPINES</div>
                    <div style="font-size: 16px; font-weight: bold;">BARANGAY 489 ZONE 48 DISTRICT IV</div>
                    <div style="font-size: 14px;">OFFICE OF THE PUNONG BARANGAY</div>
                </div>
                <img src="blogo.png" alt="Right Logo" style="height: 80px;">
            </div>

            <div style="display: flex; margin-top: 20px;">
                <!-- Left Side: Officials -->
                <div style="width: 30%; border-right: 1px solid #000; padding-right: 10px; font-size: 14px;">
                    <p><strong>Hon. Romeo V. Landicho</strong><br>Chairman</p>
                    <p>Ariel C. Raiola</p>
                    <p>Joseph G. Luna</p>
                    <p>Josephine M. Magat</p>
                    <p>Luisito T. De Mesa</p>
                    <p>Edward Carlo R. Bragais</p>
                    <p>Marlon V. Buen</p>
                    <p>Virginia L. Ferrer<br><em>– Councilman –</em></p>
                    <p>Julie Ann M. Luna<br><em>– SK Chairwoman –</em></p>
                    <p>Jayvee V. Marquez<br><em>Secretary</em></p>
                    <p>Cesaria R. Bragais<br><em>Treasurer</em></p>
                    <p style="margin-top: 20px; font-size: 12px;">1280 Carola Street Sampaloc, Manila<br><em>– Barangay Address –</em></p>
                </div>

                <!-- Right Side: Certification -->
                <div style="width: 72.5%; padding-left: 20px; font-size: 15px;">
                    <h2 style="text-align: center;">INDIGENCY</h2>
                    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
                    <p>
                        This is to certify that Mr./Ms. <strong>${data.name}</strong> is a bonafide resident of Barangay 489 Zone 48 District IV,
                        with postal address <strong>${data.address}</strong>, Sampaloc Manila.
                    </p>
                    <p>This certification is being issued upon the request of the above-mentioned name for:</p>

                    <p style="margin-left: 20px;"><strong>( ✔ ) ${data.purpose}</strong></p>

                    <p>
                        Further certify that the above mentioned is a person with good moral character, and no criminal or civil case in this Barangay.
                    </p>

                    <p>
                        IN WITNESS WHEREOF I have here unto set my hand and affixed the official seal of this office.
                        Done in the city of Manila, this <strong>${formattedDate}</strong>.
                    </p>

                    <div style="text-align: center; margin-top: 60px;">
                        <p><strong>ROMEO V. LANDICHO</strong><br>PUNONG BARANGAY</p>
                    </div>

                    <div style="margin-top: 30px; font-size: 12px; border-top: 1px solid #000; padding-top: 10px;">
                        <strong>PROVISIONS and CONDITIONS</strong><br>
                        This Certification/Clearance may be canceled or revoked anytime should the public safety and interest so demand and upon engagement in illegal transactions.
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById("indigencyContent").innerHTML = content;
    document.getElementById("indigencyModal").style.display = 'block';
    document.getElementById("indigencyOverlay").style.display = 'block';
}


function closeModalIndigency() {
    document.getElementById("indigencyModal").style.display = 'none';
    document.getElementById("indigencyOverlay").style.display = 'none';
}

function printModalIndigency() {
    const printContents = document.getElementById("indigencyContent").innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    if (currentIndigencyRow) {
        currentIndigencyRow.remove();
        currentIndigencyRow = null;
    }

    closeModalIndigency();
}
// Attach event to Indigency View links
document.querySelectorAll('.view-link-indigency').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        currentIndigencyRow = this.closest('tr');

        fetch(this.href)
            .then(res => res.json())
            .then(data => {
                if (!data.error) {
                    openModalIndigency(data);
                } else {
                    alert(data.error);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Failed to fetch data.");
            });
    });
});
</script>

		</div>
		<input type="radio" id="tabclearance" name="mytabs">
		<label for="tabclearance">Request Clearance</label>
		<div class="tab">
    <h2>REQUEST CLEARANCE</h2>

    <?php
require_once 'config.php'; // this should create $link

// DO NOT close it yet!

$sql = "SELECT id, name, age, address, status, purpose FROM tblclearance ORDER BY id DESC";
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0):
?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Status</th>
                <th>Purpose</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="clearanceTable">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr class="request-row" data-name="<?= strtolower($row['name']) ?>" data-type="clearance">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['purpose']) ?></td>
                    <td>
                        <a href="view_request.php?id=<?= $row['id'] ?>" class="view-link">View Request</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No clearance requests found.</p>
<?php endif; ?>




    <!-- Overlay and Modal -->
    <div id="overlayClearance" onclick="closeModalClearance()"></div>
<div id="requestModalClearance">
    <div id="modalContentClearance"></div>
    <button class="btn" onclick="printModalClearance()">Print</button>
    <button class="btn" onclick="closeModalClearance()">Close</button>
    </div>

    <!-- JavaScript for Modal -->
    <script>
      let currentClearanceRow = null;
      function openModalClearance(data) {
    // Get current date
    const now = new Date();

    // Format date as: "April day of 24, 2025"
    const options = { month: 'long' };
    const month = now.toLocaleDateString('en-US', options);
    const day = now.getDate();
    const year = now.getFullYear();
    const formattedDate = `${month} day of ${day}, ${year}`;

    let content = `
        <div style="display: flex; flex-direction: column; font-family: 'Times New Roman', serif; padding: 10px; width: 100%;">
            <!-- Header with logos -->
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <img src="logo.png" alt="Left Logo" style="height: 80px;">
                <div style="text-align: center; flex: 1;">
                    <div style="font-size: 14px;">REPUBLIC OF THE PHILIPPINES</div>
                    <div style="font-size: 16px; font-weight: bold;">BARANGAY 489 ZONE 48 DISTRICT IV</div>
                    <div style="font-size: 14px;">OFFICE OF THE PUNONG BARANGAY</div>
                </div>
                <img src="blogo.png" alt="Right Logo" style="height: 80px;">
            </div>

            <div style="display: flex; margin-top: 20px;">
                <!-- Left Side: Officials -->
                <div style="width: 30%; border-right: 1px solid #000; padding-right: 10px; font-size: 14px;">
                    <p><strong>Hon. Romeo V. Landicho</strong><br>Chairman</p>
                    <p>Ariel C. Raiola</p>
                    <p>Joseph G. Luna</p>
                    <p>Josephine M. Magat</p>
                    <p>Luisito T. De Mesa</p>
                    <p>Edward Carlo R. Bragais</p>
                    <p>Marlon V. Buen</p>
                    <p>Virginia L. Ferrer<br><em>– Councilman –</em></p>
                    <p>Julie Ann M. Luna<br><em>– SK Chairwoman –</em></p>
                    <p>Jayvee V. Marquez<br><em>Secretary</em></p>
                    <p>Cesaria R. Bragais<br><em>Treasurer</em></p>
                    <p style="margin-top: 20px; font-size: 12px;">1280 Carola Street Sampaloc, Manila<br><em>– Barangay Address –</em></p>
                </div>

                <!-- Right Side: Certification -->
                <div style="width: 72.5%; padding-left: 20px; font-size: 15px;">
                    <h2 style="text-align: center;">CLEARANCE</h2>
                    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
                    <p>
                        This is to certify that Mr./Ms. <strong>${data.name}</strong> is a bonafide resident of Barangay 489 Zone 48 District IV,
                        with postal address <strong>${data.address}</strong>, Sampaloc Manila.
                    </p>
                    <p>This certification is being issued upon the request of the above-mentioned name for:</p>

                    <p style="margin-left: 20px;"><strong>( ✔ ) ${data.purpose}</strong></p>

                    <p>
                        Further certify that the above mentioned is a person with good moral character, and no criminal or civil case in this Barangay.
                    </p>

                    <p>
                        IN WITNESS WHEREOF I have here unto set my hand and affixed the official seal of this office.
                        Done in the city of Manila, this <strong>${formattedDate}</strong>.
                    </p>

                    <div style="text-align: center; margin-top: 60px;">
                        <p><strong>ROMEO V. LANDICHO</strong><br>PUNONG BARANGAY</p>
                    </div>

                    <div style="margin-top: 30px; font-size: 12px; border-top: 1px solid #000; padding-top: 10px;">
                        <strong>PROVISIONS and CONDITIONS</strong><br>
                        This Certification/Clearance may be canceled or revoked anytime should the public safety and interest so demand and upon engagement in illegal transactions.
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById("modalContentClearance").innerHTML = content;
    document.getElementById("requestModalClearance").style.display = 'block';
    document.getElementById("overlayClearance").style.display = 'block';
}



function closeModalClearance() {
    document.getElementById("requestModalClearance").style.display = 'none';
    document.getElementById("overlayClearance").style.display = 'none';
}

function printModalClearance() {
    let printContents = document.getElementById("modalContentClearance").innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    if (currentClearanceRow) {
        currentClearanceRow.remove();
        currentClearanceRow = null;
    }

    closeModalClearance();
}

        // Attach click event to all links with class="view-link"
        document.querySelectorAll('.view-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        currentClearanceRow = this.closest('tr');

        fetch(this.href)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    openModalClearance(data);
                } else {
                    alert(data.error);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Unable to fetch data.');
            });
    });
});
        const today = new Date();
const formattedDate = today.toLocaleDateString('en-US', {
  year: 'numeric'
});

    </script>

	</div>
</div>
</body>
<script>
document.getElementById("requestSearchBtn").addEventListener("click", function () {
    const query = document.getElementById("requestSearchInput").value.toLowerCase().trim();
    const rows = document.querySelectorAll(".request-row");

    rows.forEach(row => {
        const name = row.getAttribute("data-name");
        const type = row.getAttribute("data-type");
        
        if (name.includes(query) || type.includes(query)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// Optional: enable real-time filtering on input
document.getElementById("requestSearchInput").addEventListener("keyup", function (e) {
    if (e.key === "Enter") {
        document.getElementById("requestSearchBtn").click();
    }
});
</script>
<footer class="footer">
    <div class="social-media">
        <a  href="https://www.facebook.com/ArellanoUniversityOfficial/"><img src="img/facebook.svg" alt="Facebook"></a>
        <a href="https://twitter.com/Arellano_U"><img src="img/twitter.svg" alt="Twitter"></a>
        <a href="https://www.instagram.com/explore/topics/495287895113599/arellano-university/"><img src="img/instagram.svg" alt="Instagram"></a>
    </div>
    <ul>
        <li><a style="color:black; text-decoration: none; margin-bottom: 50px" href="#">Terms of Service</a></li>
        <li><a style="color:black; text-decoration: none; margin-bottom: 50px" href="#">Privacy Policy</a></li>
    </ul>
</footer>
</html>
<style>
        /* --- Table Styles --- */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 30px;
            overflow-y: auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        /* --- Button Styles --- */
        .btn {
            padding: 8px 16px;
            margin: 5px;
            border: none;
            background: #007bff;
            color: white;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }

        /* --- Modal Overlay --- */
        #overlay {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);      /* semi-transparent black */
            z-index: 999;
        }
        #indigencyOverlay {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);      /* semi-transparent black */
            z-index: 999;
        }
        #overlayoverlayClearance {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);      /* semi-transparent black */
            z-index: 999;
        }
        /* --- Modal Window --- */
        #requestModal {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 5%; left: 10%;
            width: 80%;                       /* certificate width */
            background: #fff;                 /* white background */
            border: 2px solid #000;
            padding: 20px;
            z-index: 1000;                    /* above the overlay */
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            overflow: auto;                   /* scroll if content is long */
        }
        #indigencyModal {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 5%; left: 10%;
            width: 80%;                       /* certificate width */
            background: #fff;                 /* white background */
            border: 2px solid #000;
            padding: 20px;
            z-index: 1000;                    /* above the overlay */
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            overflow: auto;                   /* scroll if content is long */
        }
        #requestModalClearance {
            display: none;                    /* hidden by default */
            position: fixed;
            top: 5%; left: 10%;
            width: 80%;                       /* certificate width */
            background: #fff;                 /* white background */
            border: 2px solid #000;
            padding: 20px;
            z-index: 1000;                    /* above the overlay */
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            overflow: auto;                   /* scroll if content is long */
        }

        /* --- Certificate Layout Inside Modal --- */
        .certificate-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .certificate-header img {
            height: 60px;
            vertical-align: middle;
        }
        .certificate-title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0 0 0;
        }
        .certificate-body {
            margin-top: 20px;
            line-height: 1.5;
        }
        .certificate-body p {
            margin: 10px 0;
            text-align: justify;
        }
        .certificate-footer {
            margin-top: 40px;
        }
        .certificate-footer .signature {
            text-align: right;
            margin-top: 60px;
        }
        .certificate-footer .signature p {
            margin: 0;
        }

        /* --- Print Section --- */
        @media print {
    /* Hide everything except the modal content */
    body * {
        display: none !important;
    }

    #requestModal, #requestModal * {
        display: block !important;
        visibility: visible !important;
    }

    #requestModal {
        position: absolute !important;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        padding: 0;
        margin: 0;
        border: none;
        box-shadow: none;
        background: white !important;
    }

    .btn, #overlay {
        display: none !important;
    }

    .certificate-header img {
        max-height: 100px !important;
    }

    .certificate-body, .certificate-footer {
        page-break-inside: avoid;
    }
}
    </style>


<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    th, td {
        padding: 10px 12px;
        border: 1px solid #ccc;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #fafafa;
    }

    .view-link-indigency {
        text-decoration: none;
        color: #0066cc;
        font-weight: bold;
    }

    .view-link-indigency:hover {
        text-decoration: underline;
        color: #004999;
    }

    #requestModal {
        display: none;
        position: fixed;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 900px;
        background-color: white;
        border: 1px solid #aaa;
        padding: 20px;
        z-index: 1000;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        overflow-y: auto;
        max-height: 90%;
    }

    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .btn {
        margin: 10px 5px 0 0;
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>