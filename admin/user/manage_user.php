<style>
.toggle-password, .toggle-password1 {
    position: absolute; /* changed from fixed to absolute */
    background: none;
    border: none;
    font-size: 18px;
    color: #333;
    cursor: pointer;
}

.toggle-password {
    left: 90%;
    top: 73%;
    transform: translateY(-50%);
}

.toggle-password1 {
    left: 90%;
    top: 73%;
    transform: translateY(-50%);
}

.toggle-password:focus, .toggle-password1:focus {
    outline: none;
}

</style>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required pattern="[A-Za-z\s]+" 
        title="First name can only contain letters and spaces.">
				</div>
				<div class="form-group col-6">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required pattern="[A-Za-z\s]+" 
        title="Last name can only contain letters and spaces.">
				</div>
				<div class="form-group col-6">
    <label for="username">Username</label>
    <input 
        type="text" 
        name="username" 
        id="username" 
        class="form-control" 
        value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" 
        required 
        autocomplete="off" 
        minlength="8" 
        maxlength="16" 
        pattern="^(?=.*[0-9])[A-Za-z0-9]{8,16}$" 
        title="Username must be between 8 to 16 characters and include at least one number.">
</div>

<div class="form-group col-6">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" 
           <?php echo isset($meta['id']) ? "" : 'required' ?>
           pattern="^(?=.*[A-Z])(?=.*[!@#$%^&*_])[A-Za-z\d!@#$%^&*_]{8,16}$" 
           title="Password must be between 8 to 16 characters, with at least one uppercase letter and one special character.">
    <button type="button" id="togglePassword" class="toggle-password">
        <i class="fas fa-eye"></i>
    </button>

    <?php if(isset($_GET['id'])): ?>
        <small class="text-info"><i>Leave this blank if you don't want to change the password.</i></small>
    <?php endif; ?>
</div>

<!-- Add Confirm Password -->
<div class="form-group col-6">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="" autocomplete="off" 
           <?php echo isset($meta['id']) ? "" : 'required' ?>
           pattern="^(?=.*[A-Z])(?=.*[!@#$%^&*_])[A-Za-z\d!@#$%^&*_]{8,16}$" 
           title="Confirm password must be between 8 to 16 characters, with at least one uppercase letter and one special character.">
    <button type="button" id="toggleConfirmPassword" class="toggle-password1">
        <i class="fas fa-eye"></i>
    </button>
	<?php if(isset($_GET['id'])): ?>
        <small class="text-info"><i>Leave this blank if you don't want to change the password.</i></small>
    <?php endif; ?>
</div>

				<div class="form-group col-6">
					<label for="type">User Type</label>
					<select name="type" id="type" class="custom-select"  required>
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Administrator</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Patient</option>
					</select>
				</div>
                
				
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancel</a>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
    $(function(){
        $('.select2').select2({
            width:'resolve'
        });
    });

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage-user').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        start_loader();

        $.ajax({
            url: _base_url_ + 'classes/Users.php?f=save',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                end_loader();
                // Parse the JSON response
                var response = JSON.parse(resp);

                if (response.status == 1) {
                    // Success
                    $('#msg').html('<div class="alert alert-success">' + response.message + '</div>');
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                    location.href = './?page=user/list';  // Redirect after success
                } else {
                    // Error
                    $('#msg').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                }
            }
        });
    });
</script>


<script>
  // Password visibility toggle for "Password" field
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  
  // Ensure password is hidden by default on page load
  passwordInput.setAttribute('type', 'password');
  togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Initially show eye-slash icon

  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Toggle the icon based on the input type
    if (type === 'password') {
      this.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Eye-slash icon when password is hidden
    } else {
      this.innerHTML = '<i class="fas fa-eye"></i>'; // Eye icon when password is visible
    }
  });

  // Password visibility toggle for "Confirm Password" field
  const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
  const confirmPasswordInput = document.getElementById('confirm_password');
  
  // Ensure confirm password is hidden by default on page load
  confirmPasswordInput.setAttribute('type', 'password');
  toggleConfirmPassword.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Initially show eye-slash icon

  toggleConfirmPassword.addEventListener('click', function () {
    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPasswordInput.setAttribute('type', type);
    
    // Toggle the icon based on the input type
    if (type === 'password') {
      this.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Eye-slash icon when password is hidden
    } else {
      this.innerHTML = '<i class="fas fa-eye"></i>'; // Eye icon when password is visible
    }
  });

  // Ensure the passwords match before form submission
  document.getElementById('manage-user').addEventListener('submit', function (e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
      e.preventDefault(); // Prevent form submission
      alert('Passwords do not match!');
    }
  });
</script>
