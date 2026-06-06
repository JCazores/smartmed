<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
      /* Styles for user image */
      .user-img {
          position: absolute;
          height: 27px;
          width: 27px;
          object-fit: cover;
          left: -7%;
          top: -12%;
      }

      /* Styles for rounded buttons */
      .btn-rounded {
          border-radius: 50px;
      }

      /* Navbar styles */
      .main-header {
          height: 55px;
          border: 1px solid #3390d6; /* Border color teal */
          border-top-width: 0;
          border-left-width: 0;
          border-right-width: 0;
          background-color: #3390d6; /* Gradient background */
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow effect */
          font-size: 0.875rem; /* Font size for text-sm equivalent */
      }

      .nav-link {
          color: #fff; /* Navbar link text color */
      }

      /* Hover effect for navbar links */
      .nav-link:hover {
          color: black; /* Light grey text on hover */
      }

      .navbar-dark .navbar-nav .nav-link {
          color: rgba(255, 255, 255, 0.8); /* Color for navbar links */
      }

      .navbar-nav .nav-item .btn-rounded {
          border-radius: 50px; /* Rounded button style */
      }

      .dropdown-menu {
          min-width: 10rem; /* Adjust dropdown menu width */
      }

      .dropdown-item {
          font-size: 0.875rem; /* Font size for dropdown items */
      }

      /* Hover effect for dropdown items */
      .dropdown-item:hover {
          background-color: white; /* Dark blue background on hover */
          color: #0056b3 /* White text on hover */
      }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!--<li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo base_url ?>" class="nav-link"><b><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?></b></a>
            </li>-->
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item">
                <div class="btn-group nav-link">
                    <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <!--<span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>-->
                        <span class="ml-3"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>"><span class="fa fa-user"></span> My Account</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
</body>
</html>
