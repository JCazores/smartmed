<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once('inc/header.php') ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
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
      color: #fff;
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
    .account a {
      color: #4e34b6;
    }
    .account a:hover {
      text-decoration: underline;
    }
    @media (max-width: 736px) {
      .main {
        flex-direction: column;
      }
      .form-img {
        order: 2;
        border-radius: 0 0 8px 8px;
      }
      .content {
        order: 1;
        border-radius: 8px 8px 0 0;
      }
    }
    .toggle-password {
    position: absolute;
    left: 150px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 18px;
    color: #333;
    cursor: pointer;
  }
  .toggle-password:focus {
    outline: none;
  }
  </style>
</head>
<body class="hold-transition">
  <div class="login-form">
    <div class="container">
      <h1>SMARTMED</h1>
      <p>"Simplifying Medical Records, Empowering Care"</p>
      <div class="main">
        <div class="content">
          <form id="login-frm" method="post">
            <h2>Sign In</h2>
            <div class="input-container">
              <i class="fas fa-user icon"></i>
              <input type="text" name="username" placeholder="Username">
            </div>
            <div class="input-container">
  <i class="fas fa-lock icon"></i>
  <input type="password" id="password" name="password" placeholder="Password">
  <button type="button" id="togglePassword" class="toggle-password">
    <i class="fas fa-eye"></i>
  </button>
</div>
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Sign In</button>
            <div class="account">
              <a href="forgot.php">Forgot Password?</a>
            </div>
          </form>
        </div>
        <div class="form-img">
          <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-white">
        </div>
      </div>
    </div>
  </div>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script>
    $(document).ready(function () {
      end_loader();
    });
  </script>
  <script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function () {
    // Toggle the type attribute
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle the eye icon
    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
  });
</script>
</body>
</html>
