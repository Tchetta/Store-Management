<?php
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    header("Location: dashboard.php?page=edit_user&error=no+user+selected+to+change+password");
}

?>

<form action="../includes/change_password.inc.php" method="post">

<input type="hidden" name="user_id">

<div class="model_form-group password">    
    <label for="old_password">Old Password:</label>
    <input type="password" id="old_password" name="old_password">
</div>

<div class="model_form-group password">
    <label for="new_password">New Password:</label>
    <input type="password" id="new_password" name="new_password">
</div>

<div class="model_form-group password">
    <label for="confirm_password">Confirm New Password:</label>
    <input type="password" id="confirm_password" name="confirm_password">
</div>
<button type="submit">Submit</button>
</form>