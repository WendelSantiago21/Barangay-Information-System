<?php
require_once "config.php"; // Ensure this file contains the correct database connection

$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Change if you have a different DB username
$password = ""; // Change if you have a password set for MySQL
$database = "itc-127-2b-2024"; // Replace with your actual database name

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_type = "Certificate Request";
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $address = $_POST['address'] ?? '';
    $status = $_POST['status'] ?? '';
    
    // Handling multiple purposes
    $purposes = [];
    if (!empty($_POST['employment'])) $purposes[] = "Application for Employment";
    if (!empty($_POST['transfer'])) $purposes[] = "Transfer Residence";
    if (!empty($_POST['school'])) $purposes[] = "School Reference";
    if (!empty($_POST['travel'])) $purposes[] = "Travel Residence";
    if (!empty($_POST['other'])) $purposes[] = $_POST['other'];
    $purpose = implode(", ", $purposes);
    
    $request_date = date('Y-m-d H:i:s');

    $query = "INSERT INTO tblrequests (request_type, name, age, address, status, purpose, request_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $request_type, $name, $age, $address, $status, $purpose, $request_date);
    
    if ($stmt->execute()) {
        echo "<script>window.location.href='request-records.php';</script>";
    } else {
        echo "<script></script>";
    }
    
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Certificate</title>
</head>
<header>
	<div class="header1">
		<h2>BARANGAY 489 ZONE 48 DISTRICT VI (REQUEST A CERTIFICATE)</h2>
	</div>
</header>
<body style="background-image: url('com-picaai.png'); background-repeat: no-repeat; background-size: 2050px 900px;">
<div class="form">
    <h2>Fill up the following</h2>
    <form method="POST" action="insert-certificate.php" id="certificateForm">
        <div class="form-grid">
            <!-- Name -->
            <div class="form-group">
                <label for="name"><strong>Name</strong></label>
                <input type="text" id="name" class="input" placeholder="Enter your name" required>
            </div>
            <!-- Age -->
            <div class="form-group">
                <label for="age"><strong>Age</strong></label>
                <input type="text" id="age" class="input" placeholder="Enter your age" required>
            </div>
            <!-- Address -->
            <div class="form-group">
                <label for="address"><strong>Address</strong></label>
                <input type="text" id="address" class="input" placeholder="Enter your address" required>
            </div>
            <!-- Status -->
            <div class="form-group">
                <label for="status"><strong>Status</strong></label>
                <select id="status" name="status" required>
                    <option value="">Select your status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Separated">Separated</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
            <!-- Purposes -->
            <div class="form-group">
                <label for="purpose"><strong>Purpose of getting a certificate</strong></label>
                <div class="checkbox-group">
                    <div class="checkbox-item"><input type="checkbox" id="employment"><label for="employment" class="lbl">Employment Purpose</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="hospital"><label for="hospital" class="lbl">Hospital Requirements</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="bank"><label for="bank" class="lbl">Bank Transaction</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="financial"><label for="financial" class="lbl">Financial Assistance</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="school"><label for="school" class="lbl">School Requirement</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="business"><label for="business" class="lbl">Business Registration</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="travel"><label for="travel" class="lbl">For Travel Abroad</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="senior"><label for="senior" class="lbl">ID for Senior Citizen</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="transfer"><label for="transfer" class="lbl">Transfer of Residence</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="indigency"><label for="indigency" class="lbl">Proof of Indigency</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="maynilad"><label for="maynilad" class="lbl">Maynilad Requirement</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="loan"><label for="loan" class="lbl">Loan Purpose</label></div>
                    <div class="checkbox-item"><input type="checkbox" id="relocation"><label for="relocation" class="lbl">Relocation Purposes</label></div>
                </div>
            </div>
            <!-- Other -->
            <div class="form-group">
                <label for="other"><strong>Other</strong></label>
                <input type="text" id="other" placeholder="Specify other reasons">
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button type="button" class="button-confirm cancel" onclick="window.location.href='indexlogin.php'">Cancel</button>
                <button type="submit" class="button-confirm">Request</button>
            </div>
        </div>
    </form>
</div>

<script>
// Get selected checkbox labels
function getSelectedPurposes() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    return Array.from(checkboxes).map(cb => {
        const label = document.querySelector(`label[for="${cb.id}"]`);
        return label ? label.textContent.trim() : '';
    });
}

document.getElementById("certificateForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("name", document.getElementById("name").value);
    formData.append("age", document.getElementById("age").value);
    formData.append("address", document.getElementById("address").value);
    formData.append("status", document.getElementById("status").value);

    const purposes = getSelectedPurposes();
    const other = document.getElementById("other").value.trim();
    if (other) {
        purposes.push(other);
    }
    purposes.forEach(p => formData.append("purpose[]", p));

    fetch("insert-certificate.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(response => {
        alert("Your request has been successfully submitted!");
        window.location.href = "indexlogin.php";
    })
    .catch(err => {
        alert("Error submitting the form.");
        console.error(err);
    });
});
</script>

		</form>
	</div>
</body>
</html>
<style>
body{
	font-family: Arial, sans-serif;
    background-color: var(--bg-color);
    color: var(--font-color);
    justify-content: center;
    align-items: center;
	margin: 0px;
}
.header1{
	justify-content: center;
	height: 80px;
	width: 100%;
	display: flex;
	border-radius: 0px 0px 40px 40px;
	backdrop-filter: blur(5px);
	box-shadow: 20px 20px 30px rgba(207, 208, 207, 207);
	border: 2px solid rgba(255, 255, 255,);
}
.header1 h2{
	font-size: 28px;
	color: #FFF8F8;
	-webkit-text-stroke: 1.5px black;
}
.form{
	height: 700px;
	width: 1050px;
	background-color: #E4EFE7;
	border: 5px ridge #EAD196;
	border-radius: 10px;
	bottom: 5%;
	right: 3%;
	position: absolute;
}
.form h2{
	text-align: center;
}
.form-grid{
	padding-top: 20px;
	padding-left: 30px;
	display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two equal columns */
    gap: 15px; /* Adjust spacing between items */
    width: 100%;
}
.form-group{
	display: flex;
    flex-direction: column; /* Keeps label above input */
    gap: 5px; /* Space between label and input */
    width: 90%;
}
.form label{
	font-size: 18px;
	padding-bottom: 5px;
	padding-top: 10px;
}
.form input[type="text"]{
	height: 50px;
	border-radius: 5px;
	font-size: 18px;
	border: 3px solid #336D82;
}
.input::placeholder{
	padding-left: 7px;
}
.select::placeholder{
	padding-left: 7px;
}
.form select{
	height: 50px;
	border-radius: 5px;
	font-size: 18px;
	border: 3px solid #336D82;
}
.checkbox-group label{
	font-size: 18px;
}
.checkbox-group{
	display: grid;
	padding-top: 10px;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
	margin-bottom: 15px;
}
.checkbox-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.form input[type="checkbox"]{
	height: 15px;
	width: 15px;
}
.button-group{
	display: flex;
	position: absolute;
	bottom: 10%;
	right: 4%;
	gap: 20px;
}
.button-confirm {
    width: 200px;
    height: 50px;
    border-radius: 8px;
    border: 2px solid #336D82;
    font-size: 16px;
	font-weight: 600;
    cursor: pointer;
}
.cancel {
    border-color: #b0bec5;
}
</style>