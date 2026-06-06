<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // File Upload Handling
    $upload_dir = '../../uploads/xray_images/'; // Define the upload directory
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
    }

    $xray_image = null;
    if (isset($_FILES['xray_image']) && $_FILES['xray_image']['error'] === UPLOAD_ERR_OK) {
        $file_name = time() . '_' . $_FILES['xray_image']['name'];
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['xray_image']['tmp_name'], $file_path)) {
            $xray_image = $file_name; // Save the file name to the database
        } else {
            die(json_encode(['status' => 'error', 'msg' => 'Failed to upload X-ray image.']));
        }
    }

    // Save other form data, including $xray_image if uploaded
    $id = $_POST['id'] ?? null;
    $patient_id = $_POST['patient_id'] ?? null;
    $illness = $_POST['illness'] ?? null;
    $diagnosis = $_POST['diagnosis'] ?? null;
    $treatment = $_POST['treatment'] ?? null;
    $remarks = $_POST['remarks'] ?? null;
    $doctor_id = $_POST['doctor_id'] ?? null;

    if ($id) {
        $update_sql = "UPDATE `patient_history` SET 
            illness = '$illness', 
            diagnosis = '$diagnosis', 
            treatment = '$treatment', 
            remarks = '$remarks',
            doctor_id = '$doctor_id',
            xray_image = '$xray_image'
            WHERE id = $id";
        $conn->query($update_sql);
    } else {
        $insert_sql = "INSERT INTO `patient_history` (patient_id, illness, diagnosis, treatment, remarks, doctor_id, xray_image) 
            VALUES ('$patient_id', '$illness', '$diagnosis', '$treatment', '$remarks', '$doctor_id', '$xray_image')";
        $conn->query($insert_sql);
    }

    echo json_encode(['status' => 'success']);
    exit;
}
?>