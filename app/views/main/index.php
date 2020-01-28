<?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['errors']; unset($_SESSION['errors']) ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']) ?>
    </div>
<?php endif; ?>

<h1>MAIN PAGE</h1>