<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information System - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav>
        <ul>
            <li><a href="#">Request Certificate</a></li>
            <li><a href="#">Request Indigency</a></li>
            <li><a href="#">Request Clearance</a></li>
        </ul>
    </nav>

    <!-- Login Form Container -->
    <div class="login-container">
        <!-- Left Side: Logo and Title -->
        <div class="login-left">
            <img src="logo.png" alt="Barangay Logo">
            <h2>Barangay Information System</h2>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-right">
            <h2>Login</h2>
            <form action="#" method="POST">
                <input type="text" placeholder="Enter Username" required>
                <input type="password" placeholder="Enter Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
<style>
	/* Import Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Background Image */
body {
    background: url('un.png') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

/* Glass Effect Navigation */
nav {
    width: 100%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 15px 0;
    position: fixed;
    top: 0;
    text-align: center;
}

nav ul {
    list-style: none;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-weight: 600;
    font-size: 16px;
    padding: 10px;
    transition: 0.3s;
}

nav ul li a:hover {
    color: #f5f5f5;
    text-decoration: underline;
}

/* Login Container */
.login-container {
    display: flex;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: 500px;
    margin-top: 80px;
}

/* Left Side */
.login-left {
    flex: 1;
    text-align: center;
    padding: 20px;
}

.login-left img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 10px;
}

.login-left h2 {
    color: white;
    font-size: 18px;
    font-weight: bold;
}

/* Right Side */
.login-right {
    flex: 1;
    text-align: center;
    padding: 20px;
}

.login-right h2 {
    color: white;
    font-size: 20px;
    margin-bottom: 10px;
}

.login-right input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

.login-right button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #0288d1;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.login-right button:hover {
    background: #026aa7;
}
</style>