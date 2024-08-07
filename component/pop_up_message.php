<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-dismissible alert-success position-fixed bottom-0 end-0 w-10 m-3"
    style="margin-bottom: 90px !important; z-index: 9999;" id='success_message_popup'>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <?php echo $_SESSION['success']; ?>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-dismissible alert-danger position-fixed bottom-0 end-0 w-10 m-3" style=" z-index: 9999;"
    id='error_message_popup'>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <?php echo $_SESSION['error']; ?>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>