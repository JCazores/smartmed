<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Main Sidebar Container */
.main-sidebar {
    background-color: #fff; /* You can replace this with bg-gradient-blue if it's a specific color gradient */
    color: #fff;
}

.main-sidebar .brand-link {
    background-color: transparent;
    border: 1px solid #17a2b8; /* Border color info */
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.main-sidebar .brand-image {
    width: 1.8rem;
    height: 1.8rem;
    max-height: unset;
    object-fit: scale-down;
    object-position: center center;
    background-color: #000; /* You can change this if needed */
}

.sidebar {
    overflow-y: auto;
    overflow-x: hidden;
    
}

.nav-link {
    color: #fff; /* Text color */
}

.nav-link.active {
    background-color: #0056b3; /* Active link color */
}

.nav-link {
    color: #fff;
    background-color: #343a40;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
    border-radius: 5px;
    margin: 5px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Smooth zoom effect */
}
.nav-link.active {
    background-color: #0056b3; /* Active link color */
}
.nav-link:hover {
    transform: scale(1.05); /* Scale up by 5% */
    color: white;
    background-color: #495057;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Deeper shadow on hover */
}
/* Scrollbar styling */
.os-scrollbar {
    background-color: #f0f0f0; /* Scrollbar color */
}

.os-scrollbar-track {
    background-color: #e0e0e0; /* Track color */
}

.os-scrollbar-handle {
    background-color: #007bff; /* Handle color */
}
.nav-header {
    color: #000;
    font-weight: bold;
}
.nav-item{
    min-height: 3rem; /* Adjust height as needed */
    padding: 0.5rem; /* Adjust padding as needed */
}
    </style>
</head>
<body>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-transparent text-sm border-info shadow-sm bg-gradient-blue" style="height: 55px;">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3 bg-white">
            <span class="brand-text font-weight-bold" style="font-size: 18px; "><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="clearfix"></div>
            <!-- Sidebar Menu -->
            <nav class="mt-4">
                <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                        <a href="./" class="nav-link nav-home" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=patients" class="nav-link nav-patients" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>Patient List</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=doctors" class="nav-link nav-doctors" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-user-nurse"></i>
                            <p>Doctor List</p>
                        </a>
                    </li>
                    <?php if($_settings->userdata('type') == 1): ?>
                    <li class="nav-header">Maintenance</li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=room_types" class="nav-link nav-room_types" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>Room Types List</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=rooms" class="nav-link nav-rooms" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Room List</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list" style="color: white; border-radius: 25px">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>User List</p>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info" style="color: white; white; border-radius: 25px">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <script>
        var page;
        $(document).ready(function() {
            page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
            page = page.replace(/\//gi,'_');

            if ($('.nav-link.nav-'+page).length > 0) {
                $('.nav-link.nav-'+page).addClass('active')
                if ($('.nav-link.nav-'+page).hasClass('tree-item') == true) {
                    $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
                    $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
                }
                if ($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true) {
                    $('.nav-link.nav-'+page).parent().addClass('menu-open')
                }
            }

            $('#receive-nav').click(function() {
                $('#uni_modal').on('shown.bs.modal', function() {
                    $('#find-transaction [name="tracking_code"]').focus();
                })
                uni_modal("Enter Tracking Number", "transaction/find_transaction.php");
            })
        })
    </script>
</body>
</html>
