<?php
require('fpdf.php'); // Include FPDF library

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind SQL statement to insert form data
$stmt = $conn->prepare("INSERT INTO forms (uuid, name, phone, city) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $uuid, $name, $phone, $city);

// Generate UUID
$uuid = uniqid();

// Get form data from POST request
$name = $_POST['name'];
$phone = $_POST['phone'];
$city = $_POST['city'];

// Execute SQL statement
$stmt->execute();

// Close statement and connection
$stmt->close();
$conn->close();

// Create PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set font and font size
$pdf->SetFont('Arial','B',16);

// Write title
$pdf->Cell(0,10,'Form Data',0,1,'C');

// Write form data
$pdf->Ln();
$pdf->Cell(0,10,'UUID: '.$uuid,0,1,'L');
$pdf->Cell(0,10,'Name: '.$name,0,1,'L');
$pdf->Cell(0,10,'Phone Number: '.$phone,0,1,'L');
$pdf->Cell(0,10,'City: '.$city,0,1,'L');

// Output PDF to browser
$pdf->Output();

?>
