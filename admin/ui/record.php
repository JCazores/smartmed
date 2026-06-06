<?php
// Start the session if it's not already started
session_start();

// Include necessary files for database connection
include 'db_connection.php';  // Make sure to change the path to your actual DB connection file

// Check if the patient_id is passed in the URL
if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];  // Get patient ID from the URL parameter

    // Prepare the SQL query to fetch the patient data from the database
    $sql = "SELECT * FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the patient record exists
    if ($result->num_rows > 0) {
        $patient_data = $result->fetch_assoc();  // Fetch the patient data
    } else {
        echo "No records found for this patient.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record</title>
    <!-- You can include your stylesheets or other assets here -->
</head>
<body>

    <h1>Patient Record</h1>

    <?php if (isset($patient_data)): ?>
        <h2>Patient Details:</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($patient_data['name']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($patient_data['age']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient_data['gender']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($patient_data['address']); ?></p>
        <!-- You can display more fields based on the patient data -->

    <?php else: ?>
        <p>No patient records found.</p>
    <?php endif; ?>

</body>
</html>
