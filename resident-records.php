<?php
require_once "config.php";
require_once "session-checker.php";

$Username = $_SESSION['username'];

// Fetch account details
$query = "SELECT usertype, profile_picture FROM tblaccounts WHERE username = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "s", $Username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $Usertype, $profilePicture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Initialize variables
$letter = isset($_GET['letter']) ? $_GET['letter'] : 'A';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$show_all = isset($_GET['show_all']) ? true : false;

// Determine which query to run
if (!empty($search)) {
    $search_escaped = $link->real_escape_string($search);
    $sql = "SELECT id, first_name, last_name FROM tblresidents 
            WHERE first_name LIKE '%$search_escaped%' 
               OR last_name LIKE '%$search_escaped%' 
            ORDER BY first_name";
} elseif ($show_all) {
    $sql = "SELECT id, first_name, last_name FROM tblresidents ORDER BY first_name";
} else {
    $sql = "SELECT id, first_name, last_name FROM tblresidents 
            WHERE first_name LIKE '$letter%' ORDER BY first_name";
}

$result = $link->query($sql);

// Fetch resident details if selected
$residentDetails = null;
if (isset($_GET['resident_id'])) {
    $resident_id = intval($_GET['resident_id']);
    $sqlDetails = "SELECT * FROM tblresidents WHERE id = $resident_id";
    $residentDetails = $link->query($sqlDetails)->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Records</title>
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
			position: relative;
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
	position: absolute;
    bottom: 0; 
    width: 100%;
	height: 100px;
margin-top: 50px;
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
.alphabet-wrapper {
    display: flex;
    gap: 5px; /* spacing between columns */
    align-items: start;
	margin-left: 70px;
}

.alphabet-nav {
    display: flex;
    flex-direction: column;
    gap: 5px; /* remove vertical space */
}

.alphabet-nav a {
    display: block;
    width: 50px;
    padding: 8px 12px;
    text-decoration: none;
    font-weight: bold;
    background: #007BFF;
    color: white;
    border-radius: 6px;
    text-align: center;
    transition: 0.3s;
}
.alphabet-nav a:hover {
    background: #0056b3;
    transform: scale(1.1);
}

.alphabet-nav a.active {
    background: #28A745;
    color: white;
}
.residents-list ul {
    list-style: none;
    padding: 0;
    display: block;
    flex-wrap: wrap;
    justify-content: center; /* Center the list */
    gap: 5px;
	margin-left: 30px;
}

.residents-list li {
    background: #f8f9fa;
    padding: 8px;
    border-radius: 6px;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
    transition: 0.2s ease-in-out;
    text-align: center;
    font-size: 14px;
    width: 100px; /* Adjusted width to make it narrower */
}

.residents-list li:hover {
    background: #007BFF;
    color: white;
    transform: scale(1.05);
}

.residents-list a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    display: block;
    transition: color 0.2s;
    font-size: 13px;
}

.residents-list a:hover {
    color: white;
}
.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    background: red;
    color: white;
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 50%;
    transition: 0.3s;
}

.close-btn:hover {
    background: darkred;
}

.resident-details {
    position: relative;
    padding: 15px;
    background: #DFF0D8;
    border-radius: 8px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}
.list-h3{
	margin-left: 30px;
	margin-top: -3px;
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
    <h2 class="h2">Resident Records</h2>
	<form method="GET" class="search-form" style="margin: 20px 0;">
        <input type="text" class="search1" name="search" placeholder="Search by first or last name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="search-btn">Search</button>
        <a href="?show_all=true" class="show-btn">Show All</a>
    </form>
   <!-- Alphabet Navigation -->
<div class="alphabet-wrapper">
    <div class="alphabet-nav">
        <?php foreach (range('A', 'M') as $char) : ?>
            <a href="?letter=<?= $char ?>" class="<?= ($letter == $char && !$search && !$show_all) ? 'active' : '' ?>">
                <?= $char ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="alphabet-nav">
        <?php foreach (range('N', 'Z') as $char) : ?>
            <a href="?letter=<?= $char ?>" class="<?= ($letter == $char && !$search && !$show_all) ? 'active' : '' ?>">
                <?= $char ?>
            </a>
        <?php endforeach; ?>
    </div>
	<div class="residents-list">
        <h3 class="list-h3">Residents 
            <?php 
                if (!empty($search)) echo "(Search: " . htmlspecialchars($search) . ")";
                elseif ($show_all) echo "(All Residents)";
                else echo "($letter)";
            ?>
        </h3>
        <ul>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <li><a href="?<?= http_build_query(array_merge($_GET, ['resident_id' => $row['id']])) ?>">
                        <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>
                    </a></li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No residents found.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
    <!-- Resident Details Panel -->
    <?php if ($residentDetails) : ?>
    <div class="resident-details" id="residentDetails">
        <button class="close-btn" onclick="closeDetails()">✖</button>
        <h3 class="resident-h3">Resident Details</h3>

        <!-- Display Image -->
        <?php if (!empty($residentDetails['image_path'])) : ?>
            <div class="resident-image">
                <img src="<?= htmlspecialchars($residentDetails['image_path']) ?>" alt="Resident Image" style="max-width: 200px; height: auto; border-radius: 10px;">
            </div>
        <?php else : ?>
            <p><strong>No Image Available</strong></p>
        <?php endif; ?>

        <p class="info"><strong>Name:</strong> <?= htmlspecialchars($residentDetails['first_name'] . ' ' . $residentDetails['last_name']) ?></p>
        <p class="info"><strong>Gender:</strong> <?= htmlspecialchars($residentDetails['gender']) ?></p>
        <p class="info"><strong>Age:</strong> <?= htmlspecialchars($residentDetails['age']) ?></p>
        <p class="info"><strong>Status:</strong> <?= htmlspecialchars($residentDetails['civil_status']) ?></p>
        <p class="info"><strong>Birthday:</strong> <?= htmlspecialchars($residentDetails['birthday']) ?></p>
        <p class="info"><strong>Birthplace:</strong> <?= htmlspecialchars($residentDetails['birthplace']) ?></p>
        <p class="info"><strong>Address:</strong> <?= htmlspecialchars($residentDetails['address']) ?></p>
        <p class="info"><strong>Voter Status:</strong> <?= htmlspecialchars($residentDetails['voter_status']) ?></p>
    </div>
<?php endif; ?>

</div>

<script>
    function closeDetails() {
        document.getElementById('residentDetails').style.display = 'none';
    }
</script>

    </div>
</body>
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
  .container {height: 50%; padding: 20px; }
        .search-form input {
            padding: 5px;
            width: 500px;
font-size: 16px;
        }
        .search-form button, .search-form a {
            padding: 5px 10px;
        }
.search1{
border-radius: 5px;
border: 1px solid gray;
height: 25px;
margin-left: 70px;
}
.h2{
	margin-left: 70px;
}
.search-btn{
background-color: #28A745;
height: 34px;
width: 100px;
font-size: 16px;
color: white;
border-radius: 5px;
border: 1px solid gray;
cursor: pointer;
font-weight: bold;
}
.search-btn:hover{
background-color:lightgreen;
color: black;
}
.show-btn{
width: 100px;
padding: 10px;
background-color: #007BFF;
text-decoration: none;
border-radius: 5px;
color: white;
font-size: 16px;
border: 2px solid gray;
font-weight: bold;
}
.show-btn:hover{
background-color: lightblue;
color: black;
}
        .residents-list ul {
            list-style: none;
            padding-left: 0;
        }
        .residents-list li {
            margin-bottom: 5px;
        }
        .resident-details {
            position: absolute;
            top: 2%;
            right: 50px;
            width: 700px;
            height: 570px;
            background-color: #EDE8DC;
            border-radius: 10px;
            overflow-y: 10;
            box-shadow: 0 0 0 5px #ffffff80;
            padding: 20px;
            z-index: 1000;
border: 5px dashed #F2E2B1;
        }
.info{
margin-left: 220px;
font-size: 16px;
}
        .resident-details .close-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 20px;
        }
.resident-h3{
text-align: center;
font-size: 30px;
font-weight: bold;
margin-top: 0px;
}
        .resident-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
margin-left: 250px;
        }
    </style>