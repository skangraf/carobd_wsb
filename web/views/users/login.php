<?php
include_once('header.php');
?>

<form method="post"  class="form-signin" action="<?php echo ROOT_URL; ?>users/authenticate">
    <div class="text-center mb-4">
        <img class="mb-4" src="../../assets/img/logo.png" alt="logo">
    </div>

    <div class="form-label-group">
        <input type="text" id="email" name="email" class="form-control" placeholder="Nazwa użytkownika" required autofocus>
        <label for="email">Nazwa użytkownika</label>
    </div>

    <div class="form-label-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="Hasło" required>
        <label for="password">Hasło</label>
    </div>

    <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Zaloguj">
</form>

<?php
include_once('footer.php');
?>