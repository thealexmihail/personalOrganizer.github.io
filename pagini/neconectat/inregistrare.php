<div class="regular-form shadow-sm p-3 mb-5 bg-white rounded">
    <p>Vă rugăm completați formularul de mai jos pentru înregistrare:</p>
    <form method="post">
        <div class="mb-3">
            <label for="last-name" class="form-label">Nume</label>
            <input type="text" name="last-name" class="form-control" id="last-name">
        </div>
        <div class="mb-3">
            <label for="first-name" class="form-label">Prenume</label>
            <input type="text" name="first-name" class="form-control" id="first-name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Parola</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary">Înregistrare</button>
    </form>
</div>
<?php

if (isset($_POST['register'])) {
    $lastName = $_POST['last-name'];
    $firstName = $_POST['first-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];
    
    if (strlen(trim($lastName)) < 3) {
        $errors[] = 'Numele trebuie să conțină 3 minim caractere!';
    }
    
    if (strlen(trim($firstName)) < 3) {
        $errors[] = 'Prenumele trebuie să conțină minim 3 caractere!';
    }
    
    if (strlen(trim($password)) < 6) {
        $errors[] = 'Parola trebuie să conțină minim 6 caractere!';
    }
    
    if (!empty($errors)) {
        print '<div id="register-errors">';
        print '<br><b>Au apărut următoarele erori la înregistrare: </b><br>';
        print '<ul id="error-list-item">';
        foreach ($errors as $error) {
            print '<li>' . $error . '</li>';
        }
        print '</ul>';
        print '</div>';
    } else {
        $registerResult = registerUser($lastName, $firstName, $email, $password);
        if ($registerResult) {
            $_SESSION['user'] = $email;
            $_SESSION['welcome'] = "Bun venit, $email! Pentru a adăuga o activitate în agenda dumneavoastră personală, vă rugăm completați datele de mai jos!";
            header('location: index.php');
        } else {
            print '<div style="color: red;">Există deja un utilizator înregistrat cu această adresă de email: ' . $_POST['email'] . '.</div>';
        }
    }
}
