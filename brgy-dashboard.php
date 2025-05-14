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
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Dashboard</title>
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
            font-size: 30px;
            font-weight: bold;
            padding: 8px;
        }
        .stats {
            display: flex;
            margin: 9px 0;
padding-top: 10px;
padding-left: 45px;
    flex-direction: column;
    left: 20px;
    top: 80px;
gap: 15px;
        }
.stats input[type="number"]{
font-size: 17px;
text-align: center;
height: 30px;
width: 150px;
}
	.pop{
backgroun-color: #ffff99;
padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
height: 100px;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid black;
}
.sen{
background-color: lightgreen;
padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
height: 100px;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid black;
}
.k{
background-color: lightblue;
padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
height: 100px;
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
.tion{
font-size: 20px;
padding-bottom: 20px;
}
.nio{
font-size: 20px;
padding-bottom: 20px;
}
.kk{
font-size: 20px;
padding-bottom: 20px;
}
.info{
height: 500px;
width: 20%;
background-color: #C0C0C0;
border-radius: 5px;
border: 2px solid black;
padding: 20px;
}
.person{
height: 500px;
width: 80%;
background-color: #808080;
border-radius: 5px;
border: 2px solid black;
padding: 20px;
}
.con{
padding: 15px;
display: flex;
gap: 15px;
}
.image img{
height: 60px;
width: 60px;
}
.image-b img{
height: 60px;
width: 70px;
}
.image-c img{
height: 60px;
width: 60px;
}
.myTabs{
display: flex;
flex-wrap: wrap;
max-width: 100%;
}
.myTabs input[type='radio']{
display: none;
}
.myTabs label{
padding: 25px;
background: #C0C0C0;
font-weight: bold;
cursor: pointer;
}
.myTabs .tab{
width: 100%;
padding: 20px;
background: white;
order: 1;
display: none;
border-radius: 0px 0px 10px 10px;
}
.tab{
height: 390px;
background: white;
text-align: center;
border: 5px solid yellow;
}
.myTabs .tab h2{
font-size: 25px
}
.tab h2{
text-align: center;
}
.tab img{
height: 50px; 
width: 50px;
padding-right: 10px;
}
.myTabs input[type='radio']:checked + label + .tab{
display: block;
}
.myTabs input[type="radio"]:checked + label{
background: white;
}
.con-ba{
height: 260px;
width: 100%;
background: lightblue;
border: 5px ridge #6e93f5;
border-radius: 5px;
}
.con-sk{
height: 260px;
width: 100%;
background: #fa948c;
border: 5px ridge #fd5d50;
border-radius: 5px;
}
.grid {
padding: 20px;
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 15px;
      flex-wrap: wrap;
    }

    .card {
      display: flex;
      background-color: #ffffcc; /* light yellow right side */
      width: 220px;
      height: 100px;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
border-radius: 7px;
cursor: pointer;
    }

    .image-section {
      background-color: #faf38f;
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .image-section img {
      width: 100%;
      height: auto;
    }

    .info-section {
      width: 50%;
      padding: 10px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .position {
      font-weight: bold;
    }

    .name {
padding-top: 5px;
      font-size: 0.9em;
    }
.cards {
      display: flex;
      background-color: #ced5fb ; /* light yellow right side */
      width: 220px;
      height: 100px;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
border-radius: 7px;
cursor: pointer;
    }

    .image-sections {
      background-color: #a3b1f8;
      width: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
.image-sections img {
      width: 100%;
      height: auto;
    }
.popup {
      display: none;
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translate(-50%, -20%);
      background: white;
      border: 1px solid #333;
      padding: 20px;
      z-index: 1000;
      border-radius: 10px;
    }

    .popup img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }

    .popup input[type="text"],
    .popup input[type="file"] {
      display: block;
      margin: 10px 0;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }
	 .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }
	.modal-content {
  background: linear-gradient(100deg, lightblue, lightcoral);
  border-radius: 12px;
  width: 75%; height: 50%;
  max-width: 500px; /* Increased from 300px */
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
	}
    .modal-content img {
      width: 150px;
      height: 150px;
      border-radius: 10%;
      object-fit: cover;
      margin-bottom: 10px;
	  border: 10px ridge gray;
    }
.modal-buttons button {
  margin: 12px 8px;
  padding: 12px 20px;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  min-width: 100px;
}
.name1{
	font-size: 25px;
}
.position1{
	font-weight: bold;
	font-size: 30px;
}
    .edit { background-color: #f0ad4e; color: white; }
    .save { background-color: #5cb85c; color: white; }
    .cancel { background-color: #d9534f; color: white; }
  </style>
    <script>
        function previewImage(event, imgId) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById(imgId);
                    imgElement.src = e.target.result;
                    imgElement.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
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
		<a href="#">Activity <br>Records</a>
		<a href="request-records.php">Request<br>Records</a>
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
	<div class="header">BARANGAY 489 ZONE 48 DISTRICT IV</div>
	<div class="con">
		<div class="info">
			<div class="stats">
				<div>
					<div class="pop">
						<div class="image"><img src="population.png"></div>
						<div class="tion">Population<br></div>
						<input type="number" value="989" id="population" />
					</div>
				</div>
				<div>
					<div class="sen">
						<div class="image-b"><img src="senior.png"></div>
						<div class="nio">Seniors<br></div>
						<input type="number" value="91" id="seniors" />
					</div>
				</div>
				<div>
					<div class="k">
						<div class="image-c"><img src="kk.png"></div>
						<div class="kk">KK<br></div>
						<input type="number" value="123" id="kk" />
					</div>
				</div>
			</div>
		</div>
		<div class="person">
			<div class="myTabs">
				<input type="radio" id="tabBarangay" name="myTabs" checked="checked">
				<label for="tabBarangay">Barangay Officials</label>
				<div class="tab">
					<img src="blogo.png">
					<h2>BARANGAY OFFICIALS</h2>
					<div class="con-ba" id="barangay-container">
						<div class="grid">
							<div class="card" onclick="openModal('modalRomeo')">
								<div class="image-section">
									<img src="chairman.jpg" alt="Romeo Landicho">
								</div>
								<div class="info-section">
									<div class="position">CHAIRMAN</div>
									<div class="name">Romeo Landicho</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalAriel')">
								<div class="image-section">
									<img src="ariel.jpg" alt="Ariel Raniola">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Ariel Raniola</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalJoseph')">
								<div class="image-section">
									<img src="joseph.jpg" alt="Joseph Luna">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Joseph Luna</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalLuisito')">
								<div class="image-section">
									<img src="luisito.jpg" alt="Luisito De Mesa">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Luisito De Mesa</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalJosephine')">
								<div class="image-section">
									<img src="josephine.jpg" alt="Josephine Magat">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Josephine Magat</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalCarlo')">
								<div class="image-section">
									<img src="carlo.jpg" alt="Carlo Bragais">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Carlo Bragais</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalMarlon')">
								<div class="image-section">
									<img src="marlon.jpg" alt="Marlon Buen">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Marlon Buen</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalVirginia')">
								<div class="image-section">
									<img src="virgi.jpg" alt="Virginia Ferrer">
								</div>
								<div class="info-section">
									<div class="position">KAGAWAD</div>
									<div class="name">Virginia Ferrer</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalJayvee')">
								<div class="image-section">
									<img src="jayvee.jpg" alt="Jayvee Marquez">
								</div>
								<div class="info-section">
									<div class="position">SECRETARY</div>
									<div class="name">Jayvee Marquez</div>
								</div>
							</div>
							<div class="card" onclick="openModal('modalTeresita')">
								<div class="image-section">
									<img src="virgi.jpg" alt="Teresita Bragais">
								</div>
								<div class="info-section">
									<div class="position">TREASURER</div>
									<div class="name">Teresita Bragais</div>
								</div>
							</div>
						</div>  				
					</div>
				</div>
				<input type="radio" id="tabSk" name="myTabs">
				<label for="tabSk">SK Officials</label>
				<div class="tab">
					<img src="slogo.png">
					<h2>SANGGUNIANG KABATAAN OFFICIALS</h2>
					<div class="con-sk" id="sk-container">
						<div class="grid">
							<div class="cards" onclick="openModal('modalJulie')">
								<div class="image-sections">
									<img src="julie.jpg" alt="Julie Luna">
								</div>
								<div class="info-section">
									<div class="position">SK CHAIRMAN</div>
									<div class="name">Julie Luna</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalAngelo')">
								<div class="image-sections">
									<img src="angelo.jpg" alt="Angelo Acero">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Angelo Acero</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalCourtney')">
								<div class="image-sections">
									<img src="court.jpg" alt="Courtney Besmonte">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Courtney Besmonte</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalMenard')">
								<div class="image-sections">
									<img src="menard.jpg" alt="Menard Agustin">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Menard Agustin</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalHannah')">
								<div class="image-sections">
									<img src="hannah.jpg" alt="Hannah Portales">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Hannah Portales</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalYana')">
								<div class="image-sections">
									<img src="yana.jpg" alt="Yana Mandapat">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Yana Mandapat</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalChinee')">
								<div class="image-sections">
									<img src="tala.jpg" alt="Chinee Beltran">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Chinee Beltran</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalJustin')">
								<div class="image-sections">
									<img src="justin.jpg" alt="Justin Liwag">
								</div>
								<div class="info-section">
									<div class="position">SK KAGAWAD</div>
									<div class="name">Justin Liwag</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalGuian')">
								<div class="image-sections">
									<img src="hannah.jpg" alt="Guian De Guzman">
								</div>
								<div class="info-section">
									<div class="position">SK SECRETARY</div>
									<div class="name">Guian De Guzman</div>
								</div>
							</div>
							<div class="cards" onclick="openModal('modalJoshua')">
								<div class="image-sections">
									<img src="joshua.jpg" alt="Joshua Limquenco">
								</div>
								<div class="info-section">
									<div class="position">SK TREASURER</div>
									<div class="name">Joshua Limquenco</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<script>
  const officials = [
    { id: 'Romeo', name: 'Romeo Landicho', position: 'Chairman', photo: 'chairman.jpg' },
    { id: 'Ariel', name: 'Ariel Raniola', position: 'Kagawad', photo: 'ariel.jpg' },
    { id: 'Joseph', name: 'Joseph Luna', position: 'Kagawad', photo: 'joseph.jpg' },
    { id: 'Luisito', name: 'Luisito De Mesa', position: 'Kagawad', photo: 'luisito.jpg' },
    { id: 'Josephine', name: 'Josephine Magat', position: 'Kagawad', photo: 'josephine.jpg' },
    { id: 'Carlo', name: 'Carlo Bragais', position: 'Kagawad', photo: 'carlo.jpg' },
    { id: 'Marlon', name: 'Marlon Buen', position: 'Kagawad', photo: 'marlon.jpg' },
    { id: 'Virginia', name: 'Virginia Ferrer', position: 'Kagawad', photo: 'virgi.jpg' },
    { id: 'Jayvee', name: 'Jayvee Marquez', position: 'Secretary', photo: 'jayvee.jpg' },
    { id: 'Teresita', name: 'Teresita Bragais', position: 'Treasurer', photo: 'virgi.jpg' },
	{ id: 'Julie', name: 'Julie Luna', position: 'SK Chairman', photo: 'julie.jpg' },
    { id: 'Angelo', name: 'Angelo Acero', position: 'SK Kagawad', photo: 'angelo.jpg' },
    { id: 'Courtney', name: 'Courtney Besmonte', position: 'SK Kagawad', photo: 'court.jpg' },
    { id: 'Menard', name: 'Menard Agustin', position: 'SK Kagawad', photo: 'menard.jpg' },
    { id: 'Hannah', name: 'Hannah Portales', position: 'SK Kagawad', photo: 'hannah.jpg' },
    { id: 'Yana', name: 'Yana Mandapat', position: 'SK Kagawad', photo: 'yana.jpg' },
    { id: 'Chinee', name: 'Chinee Beltran', position: 'SK Kagawad', photo: 'tala.jpg' },
    { id: 'Justin', name: 'Justin Liwag', position: 'SK Kagawad', photo: 'justin.jpg' },
    { id: 'Guian', name: 'Guian De Guzman', position: 'SK Secretary', photo: 'hannah.jpg' },
    { id: 'Joshua', name: 'Joshua Limquenco', position: 'SK Treasurer', photo: 'joshua.jpg' }
  ];

  // Generate Modals
  officials.forEach(off => {
    document.body.insertAdjacentHTML('beforeend', `
      <div id="modal${off.id}" class="modal">
        <div class="modal-content">
		  <p class="position1">${off.position}</p>
          <img src="${off.photo}" alt="${off.name}">
          <h3 class="name1">${off.name}</h3>
          <div class="modal-buttons">
            <button class="cancel" onclick="closeModal('modal${off.id}')">Close</button>
          </div>
        </div>
      </div>
    `);
  });

  function openModal(id) {
    document.getElementById(id).style.display = 'flex';
  }

  function closeModal(id) {
    document.getElementById(id).style.display = 'none';
  }
</script>
			</div>
		</div>
	</div>
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
