<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `patient_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }

        $details = $conn->query("SELECT * FROM `patient_details` where patient_id = '{$id}' ");
        while($row = $details->fetch_assoc()){
            ${$row['meta_field']} = $row['meta_value'];
        }
    }
}
?>
<style>
    #cimg{
        object-fit:scale-down;
        object-position:center center;
        height:200px;
        width:200px;
    }
</style>
<div class="container-fluid">
    <form action="" id="patient-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="firstname" class="control-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control form-control-border" placeholder="First Name" value ="<?php echo isset($firstname) ? $firstname : '' ?>" required pattern="[A-Za-z\s]+" title="First name can only contain letters and spaces.">
            </div>
            <div class="form-group col-md-6">
                <label for="middlename" class="control-label">Middle Name</label>
                <input type="text" name="middlename" id="middlename" class="form-control form-control-border" placeholder="Middle Name" value ="<?php echo isset($middlename) ? $middlename : '' ?>" required pattern="[A-Za-z\s]+" title="First name can only contain letters and spaces.">
            </div>
            <div class="form-group col-md-6">
                <label for="lastname" class="control-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control form-control-border" placeholder="Last Name" value ="<?php echo isset($lastname) ? $lastname : '' ?>" required pattern="[A-Za-z\s]+" title="First name can only contain letters and spaces.">
            </div>
            <div class="form-group col-md-6">
                <label for="suffix" class="control-label">Suffix <em>(If Any)</em></label>
                <select name="suffix" id="suffix" class="form-control form-control-border">
                    <option value="">Select Suffix</option>
                    <option value="Sr" <?php echo isset($suffix) && $suffix == 'Sr' ? 'selected' : ''; ?>>Sr</option>
                    <option value="Jr" <?php echo isset($suffix) && $suffix == 'Jr' ? 'selected' : ''; ?>>Jr</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="gender" class="control-label">Gender</label>
                <select name="gender" id="gender" class="form-control form-control-border" required>
                    <option <?= isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option <?= isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="form-group col-md-6">
    <label for="dob" class="control-label">Date of Birth</label>
    <input type="date" name="dob" id="dob" class="form-control form-control-border" placeholder="Date of Birth" value ="<?php echo isset($dob) ? date('Y-m-d', strtotime($dob)) : '' ?>" required
    max="<?php echo date('Y-m-d'); ?>">
</div>

            <!-- Age Field (to be calculated automatically) -->
            <div class="form-group col-md-6">
                <label for="age" class="control-label">Age</label>
                <input type="text" name="age" id="age" class="form-control form-control-border" value ="<?php echo isset($age) ? $age : '' ?>" readonly>
            </div>
            <div class="form-group col-md-6">
    <label for="weight" class="control-label">Weight (kg)</label>
    <input type="number" name="weight" id="weight" class="form-control form-control-border" placeholder="Weight" value ="<?php echo isset($weight) ? $weight : '' ?>" required min="1" step="any" title="Please enter a valid weight. The weight must be a positive number greater than zero." pattern="^[0-9]+(\.[0-9]+)?$">
</div>

        </div>
        <div class="row">
        <div class="form-group col-md-6">
    <label for="email" class="control-label">Email</label>
    <input type="email" name="email" id="email" class="form-control form-control-border" placeholder="Email" value ="<?php echo isset($email) ? $email : '' ?>" required 
    title="Please enter a valid email address.">
</div>

<div class="form-group col-md-6">
    <label for="contact" class="control-label">Contact #</label>
    <input type="text" name="contact" id="contact" class="form-control form-control-border" placeholder="Contact #" 
        value ="<?php echo isset($contact) ? $contact : '' ?>" required
        pattern="^09\d{9}$" 
        maxlength="11" 
        title="Contact number must start with '09' followed by exactly 9 digits."
        aria-describedby="contactHelp">
    <small id="contactHelp" class="form-text text-muted">Example: 09123456789</small>
</div>


        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="address" class="control-label">Address</label>
                <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" placeholder="Block 6, Lot 23, Here Subd., There City, 2306" required><?php echo isset($address) ? $address : '' ?></textarea>
            </div>
        </div>
        
    </form>
</div>

<script>
    $(function() {
        // Function to calculate age from Date of Birth
        $('#dob').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            $('#age').val(age); // Set the calculated age in the age field
        });

        // Form submit with validation
        $('#patient-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            
            // Check if required fields are filled correctly
            var isValid = true;
            $(this).find('[required]').each(function() {
                if ($(this).val() == '' || !this.checkValidity()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                el.addClass("alert-danger");
                el.text("Please fill out all required fields correctly.");
                _this.prepend(el);
                el.show('slow');
                return;
            }

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_patient",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.href = './?page=patients/view_patient&id=' + resp.pid;
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger");
                        el.text("An error occurred due to an unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>

