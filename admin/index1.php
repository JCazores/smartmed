<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Role Selection</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: #f5f5f5;
    }
    .container {
      text-align: center;
    }
    .container img {
      width: 350px;
      height: 350px;
      border-radius: 50%;
      margin-bottom: 20px;
    }
    .buttons {
      align-items: center;
      display: flex;
      gap: 150px;
    }
    .buttons button {
      padding: 15px 30px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      background: #008cff;
      color: #fff;
      cursor: pointer;
      transition: transform 0.3s ease, background-color 0.3s ease;
    }
    .buttons button:hover {
        transform: scale(1.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="med logo.png" alt="Logo or Illustration">
    <div class="buttons">
      <button onclick="location.href='login.php?user=patient'">Patient</button>
      <button onclick="location.href='login.php?user=admin'">Admin</button>
    </div>
  </div>
</body>
</html>
