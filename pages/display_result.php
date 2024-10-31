<?php

$error = isset($_GET['error']) ? htmlspecialchars(urldecode($_GET['error'])) : '';
$success = isset($_GET['success']) ? htmlspecialchars(urldecode($_GET['success'])) : '';

?>

<div id="messages">
    <?php if (isset($success) && $success !== ''): ?>
        <div class="message-box success">
            <span class="close-btn" onclick="closeMessage(this)">×</span>
            <p>Success: <br> <?= $success ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($error) && $error !== ''): ?>
        <div class="message-box error">
            <span class="close-btn" onclick="closeMessage(this)">×</span>
            <p>Error: <br> <?= $error ?></p>
        </div>
    <?php endif; ?>
</div>
