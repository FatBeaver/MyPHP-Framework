<h1>Авторизация</h1>

<?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['errors']; unset($_SESSION['errors']) ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error-login'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error-login']; unset($_SESSION['error-login']) ?>
    </div>
<?php endif; ?>

<form action="/user/login" method="POST">
    <div class="form-group">
        <label for="login">Email</label>
        <input type="text" name="email" class="form-control" id="email" placeholder="Email"
               value="<?=isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''?>">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль"
               value="<?=isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''?>">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="rememberMe" value="1" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Запомнить меня:</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Войти</button>
</form>

<?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>