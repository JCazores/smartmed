<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('inc/header.php') ?>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Styles for the cover image */
#cover-img {
    object-fit: cover;
    object-position: center center;
    width: 100%;
    height: 100%;
}
.bg-gradient-light {
    background: linear-gradient(180deg, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
}

.bg-gradient-info {
    background: linear-gradient(180deg, rgba(0,123,255,0.5) 0%, rgba(0,123,255,0) 100%);
}

.bg-gradient-primary {
    background: linear-gradient(180deg, rgba(0,123,255,0.5) 0%, rgba(0,123,255,0) 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(180deg, rgba(108,117,125,0.5) 0%, rgba(108,117,125,0) 100%);
}

.shadow {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.form-img{
        flex-basis: 50%;
        background-size: cover;
        padding: 20px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        align-items: center;
        display: grid;
        margin-left: 120px;
    }
    .form-img img{
      height: 100%;
      width: 150%;
      
    }
    .description {
    font-family: 'Arial', sans-serif; /* Professional, clean font */
    font-size: 1.1rem; /* Adjusted for readability */
    line-height: 1.6; /* Increased line height for better text flow */
    color: #333; /* Dark grey for a softer reading experience than black */
    text-align: justify; /* Makes the text more aligned on both sides */
    background-color: #f4f9fd; /* Light blue background to add a subtle healthcare feel */
    padding: 20px; /* Space around the text */
    border-left: 5px solid #007bff; /* Blue left border for a modern look */
    border-radius: 5px; /* Slight rounding on the corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for a lifted effect */
    max-width: 800px; /* Restricting width for better readability */
    margin: 20px auto; /* Centering the paragraph horizontally */
}
    </style>
</head>
<body>
    <h1>Welcome to <?php echo $_settings->info('name') ?></h1>
    <hr class="border-info">
    <div class="row">
    <?php if($_settings->userdata('type') == 2): ?>
    <div class="form-img">
        <img src="<?php echo validate_image($_settings->info('cover')) ?>" alt="Store Logo" class="brand-image img-square elevation-3 bg-white">
        </div>
        <div class="description">
        <p>SmartMed System is a cutting-edge healthcare platform designed to give patients convenient access to their complete medical history. With its intuitive interface, users can securely view past diagnoses, lab results, prescriptions, and treatment plans anytime, anywhere. The system ensures that all medical records are consolidated in one place, enabling seamless continuity of care. Whether you’re tracking your health over time or sharing your records with healthcare providers, SmartMed simplifies the process, ensuring your health information is always accessible, up-to-date, and protected by industry-leading security standards.</p>
        </div>
        <?php endif; ?>
        <!--<?php if($_settings->userdata('type') == 1): ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);">
                <span class="info-box-icon bg-white" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Room Types</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `room_type_list` where delete_flag =0 ")->num_rows;
                        ?>
                    </span>
                </div>
                
            </div>
            
        </div>
        <?php endif; ?>
        <?php if($_settings->userdata('type') == 1): ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);">
                <span class="info-box-icon bg-white" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);"><i class="fas fa-door-open"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Rooms</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `room_list` where delete_flag = 0 ")->num_rows;
                        ?>
                    </span>
                </div>
                
            </div>
            
        </div>-->
        <?php endif; ?>
        <?php if($_settings->userdata('type') == 1): ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);">
                <span class="info-box-icon bg-white" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);"><i class="fa-solid fa-user-doctor"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Doctors</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `doctor_list` where delete_flag = 0 ")->num_rows;
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <?php endif; ?>
        <?php if($_settings->userdata('type') == 1): ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);">
                <span class="info-box-icon bg-white" style="box-shadow: 0 4px 6px rgba(0,0,0,0.8);"><i class="fas fa-user-injured"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Patients</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `patient_list`")->num_rows;
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <?php endif; ?>
    </div>
    <hr>
</body>
</html>
