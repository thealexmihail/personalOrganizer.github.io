<div class="regular-form shadow-sm p-3 mb-5 bg-white rounded">
    <p>Introduceți <i>adresa de email</i> și <i>parola</i> pentru conectare:</p>
    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Adresa de email</label>
            <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Parola</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <button type="submit" name="connect" class="btn btn-primary">Conectare</button>
    </form>
</div>
<br>
<?php
if (isset($_SESSION['fail_login'])) {
    print $_SESSION['fail_login'];
}
