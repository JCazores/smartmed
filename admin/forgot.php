<?php
require_once('../config.php'); // Ensure this includes database connection settings

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libs/PHPMailer/src/Exception.php';
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

// Initialize messages
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = $_POST['email'];
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verify email exists in the database
        $stmt = $pdo->prepare("SELECT * FROM patient_list WHERE email = :email");
$stmt->execute(['email' => $email]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            // Fetch user details
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $fullname = $user['fullname']; // Assuming 'fullname' is a field in the database

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'smartmedsystem@gmail.com'; // Replace with your email
            $mail->Password = 'dxrc vypx qelu irfj'; // Replace with your app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($mail->Username, 'SmartMed');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Username and Password Reset Request';

            // Embed the image (relative path to your local image)
            $imagePath = '../uploads/med logo.png'; // Update with the actual path
            $mail->addEmbeddedImage($imagePath, 'logo_cid'); // 'logo_cid' is the CID for reference in the HTML

            // HTML email body with embedded image
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        background-color: #f4f4f4;
                    }
                    .email-container {
                        text-align: center;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        width: 90%;
                        max-width: 600px;
                    }
                    .email-container img {
                        width: 100px;
                        margin-bottom: 20px;
                    }
                    .email-container p {
                        font-size: 16px;
                        color: #333;
                    }
                    .email-container .footer {
                        font-size: 14px;
                        color: #888;
                        margin-top: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <img src='cid:logo_cid' alt='Logo' width='500'>
                    <p>Hello $fullname,</p>
                    <p>We have received a request to reset your username and password.</p>
                    <p>If you did not request this change, please ignore this email.</p>
                    <p>Wait for our email to send your new username and password.</p>
                    <p>Best regards,<br>SmartMed Team</p>
                    <div class='footer'>
                        <p>&copy; 2024 SmartMed. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        

            $mail->send();
            $success = "Password reset email sent!";
            // Save the current time to indicate the time of the last request
            $_SESSION['lastRequestTime'] = time(); // Store in session or database
        } else {
            $error = "Email not found.";
        }
    } catch (Exception $e) {
        $error = "Failed to send email. Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Forgot Password - SmartMed</title>
 
  <style>
    /* Simplified CSS */
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
      display: grid;
      place-items: center;
      height: 100vh;
    }
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: 'Microsoft YaHei', sans-serif;
    }
    html, body {
      height: 100%;
    }
    .login-form {
      position: relative;
      height: 100%;
      background: #fff0;
      display: grid;
      grid-template-rows: 1fr auto 1fr;
      align-items: center;
      padding: 30px;
    }
    .container {
      width: 800px;
      margin: 0 auto;
    }
    .container p {
      font-size: 1.25rem;
      color: black;
      text-align: center;
    }
    .login-form h1 {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 400;
      color: black;
    }
    .login-form h2 {
      text-align: center;
      font-size: 30px;
      font-weight: 500;
      color: black;
      margin-bottom: 5px;
    }
    .main {
      display: flex;
      margin: 30px 0;
    }
    .content, .form-img {
      flex-basis: 50%;
      padding: 20px;
    }
    .content {
      background-color: #fff0;
      box-shadow: 2px 9px 49px -17px rgba(0, 0, 0, 0.1);
      border-radius: 8px 0 0 8px;
    }
    .form-img {
      background: #c0c0c0;
      display: grid;
      align-items: center;
      border-radius: 0 8px 8px 0;
    }
    .form-img img {
      width: 100%;
      height: 90%;
    }
    .input-container {
      position: relative;
      margin-bottom: 15px;
    }
    .input-container input {
      width: 100%;
      padding: 14px 20px 14px 40px;
      border: 1px solid #ccc;
      background: #f7fafc;
      border-radius: 8px;
      transition: 0.3s ease;
    }
    .input-container input:focus {
      background: transparent;
      border-color: #4e34b6;
    }
    .input-container .icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: black;
    }
    button {
      width: 100%;
      padding: 14px;
      font-size: 18px;
      font-weight: 600;
      background: #c0c0c0;
      border: none;
      border-radius: 35px;
      color: black;
      transition: 0.3s ease;
    }
    button:hover {
      color: #272346;
    }
    .message {
      text-align: center;
      color: red;
      margin: 10px 0;
    }
    .message.success {
      color: green;
    }
    .timer {
      text-align: center;
      color: red;
      margin-top: 15px;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="login-form">
  <div class="container">
    <h1>SMARTMED</h1>
    <p style="text-align: center;">"Simplifying Medical Records, Empowering Care"</p>
    <div class="main">
      <div class="content">
        <form id="forgot-password-frm" method="post">
          <h2>Forgot Password</h2>
          <?php if ($success): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
          <?php elseif ($error): ?>
            <div class="message"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>
          <div class="input-container">
            <i class="fas fa-envelope icon"></i>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <button type="submit" id="send-request-btn"><i class="fas fa-sign-in icon"></i> Send Password Reset Request</button>
          <p id="timer" class="timer"></p>
          <p class="account">Remembered? <a href="login.php">Sign In</a></p>
        </form>
      </div>
      <div class="form-img">
        <img src="<?php echo validate_image($_settings->info('logo')); ?>" alt="Logo">
      </div>
    </div>
  </div>
</div>

<script>
  let lastRequestTime = <?php echo isset($_SESSION['lastRequestTime']) ? $_SESSION['lastRequestTime'] : 'null'; ?>;
const timerDisplay = document.getElementById('timer');
const sendRequestBtn = document.getElementById('send-request-btn');

function startTimer() {
  const interval = 300; // 5 minutes in seconds
  const now = Math.floor(Date.now() / 1000);
  const end = lastRequestTime + interval;
  const remaining = end - now;

  if (remaining > 0) {
    sendRequestBtn.disabled = true;

    const countdown = setInterval(() => {
      const timeLeft = end - Math.floor(Date.now() / 1000);
      if (timeLeft <= 0) {
        clearInterval(countdown);
        timerDisplay.textContent = "";
        sendRequestBtn.disabled = false;
      } else {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerDisplay.textContent = `Please wait ${minutes}:${seconds < 10 ? '0' : ''}${seconds} before trying again.`;
      }
    }, 1000);
  }
}

sendRequestBtn.addEventListener('click', function (event) {
  event.preventDefault(); // Prevent the default form submission to avoid page reload

  const email = document.getElementById('email').value;

  if (!email) {
    alert("Please enter a valid email address.");
    return;
  }

  const now = Math.floor(Date.now() / 1000);

  if (lastRequestTime && now - lastRequestTime < 300) {
    alert("You cannot send another request yet. Please wait.");
    startTimer();
    return;
  }

  // Update the last request time and start the timer
  lastRequestTime = now;
  // Store the new lastRequestTime in PHP session using AJAX or localStorage
  <?php $_SESSION['lastRequestTime'] = 'now'; ?>  // This line won't work in JavaScript but is meant to indicate saving on the server

  startTimer();

  // Optionally, submit the form here if you want to trigger the backend process
  document.getElementById('forgot-password-frm').submit();
});

</script>

</body>
</html>
