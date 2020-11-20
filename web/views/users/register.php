<?php
include_once('header.php');
?>
    <form method="post" class="form-signin" action="<?php echo ROOT_URL; ?>users/createAccount">
        <div class="text-center mb-4">
            <img class="mb-4" src="../../assets/img/logo.png" alt="logo">
        </div>

        <div class="form-label-group">
            <input type="text" id="name" name="name" class="form-control" placeholder="Imię" required>
            <label for="name">Imię</label>
        </div>

        <div class="form-label-group">
            <input type="text" id="surname" name="surname" class="form-control" placeholder="Nazwisko" required>
            <label for="name">Nazwisko</label>
        </div>

        <div class="form-label-group">
            <input type="text" id="email" name="email" class="form-control" placeholder="email" required>
            <label for="name">email</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="hasło" required>
            <label for="password">hasło</label>
        </div>

        <input class="btn btn-primary" name="submit" type="submit" value="Zakładam konto" />
    </form>
<?php
include_once('footer.php');
?>