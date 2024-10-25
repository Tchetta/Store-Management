<?php
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    header("Location: dashboard.php?page=edit_user&error=no+user+selected+to+change+password");
}
?>
<div class="model_container model_mt-5">
    <form action="../includes/change_password.inc.php" method="post">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        
        <div class="model_form-group password-container">    
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password">
            <span class="eye-icon" onclick="togglePassword('old_password', 'eyeIconOld')">
                <i class="fas fa-eye" id="eyeIconOld"></i>
            </span>
        </div>

        <div class="model_form-group password-container">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <span class="eye-icon" onclick="togglePassword('new_password', 'eyeIconNew')">
                <i class="fas fa-eye" id="eyeIconNew"></i>
            </span>
        </div>

        <div class="model_form-group password">
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <button type="submit">Submit</button>
    </form>

    <div class="back-arrow-container">
        <a href="javascript:history.back()" class="back-arrow">
            &#8592; Back
        </a>
    </div>
</div>

<script>
function togglePassword(fieldId, iconId) {
    var passwordField = document.getElementById(fieldId);
    var eyeIcon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
