<h1>Регистрация</h1>

<?php if (isset($_SESSION['errors'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['errors']; unset($_SESSION['errors']) ?>
    </div>
<?php endif; ?>

<form action="/user/sign-up" method="POST">
    <div class="form-group">
        <label for="exampleInputEmail1">Email </label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
               aria-describedby="emailHelp" placeholder="Введите email"
               value="<?=isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''?>">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль"
               value="<?=isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''?>">
    </div>
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Ваше имя"
               value="<?=isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : ''?>">
    </div>
    <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" name="login" class="form-control" id="login" placeholder="Логин"
               value="<?=isset($_SESSION['form_data']['login']) ? $_SESSION['form_data']['login'] : ''?>">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1"
               name="rememberMe" value="1">
        <label class="form-check-label" for="exampleCheck1">Запомнить меня:</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Регистрация</button>
</form>

<?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>