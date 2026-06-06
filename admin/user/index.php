<?php 
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
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
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
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
				<!--<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>-->
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
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
	function displayImg(input,_this) {
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
var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.reload()
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_loader()
				}
			}
		})
	})

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
