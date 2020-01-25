<h1>Авторизация</h1>

<form action="/user/login" method="POST">
    <div class="form-group">
        <label for="login">Логин</label>
        <input type="text" name="login" class="form-control" id="login" placeholder="Логин"
               value="<?=isset($_SESSION['form_data']['login']) ? $_SESSION['form_data']['login'] : ''?>">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль"
               value="<?=isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''?>">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="rememberMe" value="yes" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Запомнить меня:</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Войти</button>
</form>

<?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>