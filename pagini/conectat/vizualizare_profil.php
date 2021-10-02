<!--Vizualizare profil:
Poza de profil sau o poza default de tip ‘no profile pic’ (daca nu exista o poza salvata in baza de date)
O lista sau tabel cu toate datele utilizatorului
Un formular pentru adaugarea pozei de profil-->
<div id="welcome-header">
    <?php
    $user = getUserByEmail($_SESSION['user']);
    print '<p id="welcome-text">Bun venit, ' . $user['prenume'] . " " . $user['nume'] . '!</p>';
    ?>
    
    <div id="update-profile-picture-only">
        <img 
        class="rounded-circle"
        width="150px"
        height="150px"
        src="imagini/<?php print (!empty($user['poza_profil'])) ? $user['poza_profil'] : 'no-img.jpg'; ?>"
        onerror="this.onerror=null; this.src='imagini/no-img.jpg'"
        style=" display: block;
                margin-left: auto;
                margin-right: auto;"
                /><br>
        <form method="post" enctype="multipart/form-data">    
            <div class="mb-3">
                <label for="pictureFile" class="form-label">Alegeți o poză de profil</label>
                <input class="form-control" type="file" id="pictureFile" name="picture-update"/>
            </div>
            <button type="submit" name="picture-update" class="btn btn-primary">Actualizați poza profilului</button>
        </form>
    </div>
    
    <?php
    if (isset($_POST['picture-update'])) {
        if (isset($_FILES['picture-update'])) {
            if ($_FILES['picture-update']['error'] == 0) {
                switch ($_FILES['picture-update']['type']) {
                    case 'image/jpg';
                    case 'image/jpeg';
                    case 'image/png';
                    case 'image/bmp';
                    case 'image/gif';
                        $profilePicture = uniqid() . $_FILES['picture-update']['name'];
                        $moveProfilePicture = move_uploaded_file($_FILES['picture-update']['tmp_name'], 'imagini/' . $profilePicture);
                        if ($moveProfilePicture) {
                            $updateProfilePicture = updateProfilePicture($_SESSION['user'], $profilePicture);
                            if ($updateProfilePicture) {
                                if (!empty($user['poza_profil'])) {
                                    unlink('imagini/' . $produs['poza_profil']);
                                }
                                header("location: index.php?page=2");
                            } else {
                                unlink('imagini/' . $profilePicture);
                                print 'Eroare la salvarea pozei de profil';
                            }
                        } else {
                            print 'Eroare la salvarea pe server';
                        }
                        break;
                    default:
                        print 'Fisierul selectat nu are un format acceptat!';
                        break;
                }
            } elseif ($_FILES['picture-update']['error'] == 4) {
                $updateProfilePicture = updateProfilePicture($_SESSION['user'], NULL);
                if ($updateProfilePicture) {
                    header("location: index.php?page=2");
                } else {
                    print 'Eroare la actualizarea pozei de profil';
                }
            } else {
                print 'Eroare la salvarea pozei de profil';
            }
        }
    }
    ?>
    
    <p id="welcome-text-below">Gestionați-vă informațiile, confidențialitatea și securitatea pentru ca Agenda dvs. personală să vă fie mai sigură. 
        <a href="#">Aflați mai multe</a><br>
        <img src="imagini/securitate.png" id="security-image"/>
    </p>
    <p id="welcome-text-below">Actualizați datele de profil:</p>
</div>

<div id="update-credentials-form">
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="current-last-name" class="form-label"><i>Nume actual</i></label>
            <input class="form-control" name="current-last-name" type="text" placeholder="<?php print $user['nume']?>" aria-label="Disabled input example" disabled>
        <div class="mb-3">
            <label for="last-name" class="form-label"><b>Introduceți noul nume</b></label>    
            <input type="text" name="last-name" class="form-control" id="last-name">
        </div>
        <div class="mb-3">
            <label for="current-first-name" class="form-label"><i>Prenume actual</i></label>
            <input class="form-control" name="current-first-name" type="text" placeholder="<?php print $user['prenume']?>" aria-label="Disabled input example" disabled>
        <div class="mb-3">
            <label for="first-name" class="form-label"><b>Introduceți noul prenume</b></label>    
            <input type="text" name="first-name" class="form-control" id="first-name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><i>Email</i></label>
            <input class="form-control" name="email" type="text" placeholder="<?php print $user['email']?>" aria-label="Disabled input example" disabled>
        <div class="mb-3">
            <label for="current-password" class="form-label"><i>Introduceți parola actuală</i></label>
            <input type="password" name="current-password" class="form-control" id="current-password">
        </div>
        <div class="mb-3">
            <label for="new-password" class="form-label"><b>Introduceți noua parolă</b></label>
            <input type="password" name="new-password" class="form-control" id="new-password">
        </div>
        <div class="mb-3">
            <label for="confirm-new-password" class="form-label"><b>Confirmați noua parolă</b></label>
            <input type="password" name="confirm-new-password" class="form-control" id="last-name">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Alegeți o poză de profil</label>
            <input class="form-control" type="file" id="formFile" name="image"/>
        </div>
        <button type="submit" name="data-update" class="btn btn-primary">Actualizați datele profilului</button>
    </form>
</div>
<?php            
if (isset($_POST['data-update'])) {
    $newLastName = $_POST['last-name'];
    $newFirstName = $_POST['first-name'];
    $oldPass = $_POST['current-password'];
    $newPass = $_POST['new-password'];
    $newPassConfirm = $_POST['confirm-new-password'];
    $errors = [];
    
    if (strlen(trim($newLastName)) < 3) {
        $errors[] = 'Numele trebuie să conțină 3 minim caractere!';
    }
    
    if (strlen(trim($newFirstName)) < 3) {
        $errors[] = 'Prenumele trebuie să conțină minim 3 caractere!';
    }
    
    if (strlen(trim($newPass)) < 6) {
        $errors[] = 'Noua parolă trebuie să conțină minim 6 caractere!';
    }
    
    if (!empty($errors)) {
        print '<div id="register-errors">';
        print '<br><b>Au apărut următoarele erori la actualizarea datelor de contact: </b><br>';
        print '<ul id="error-list-item">';
        foreach ($errors as $error) {
            print '<li>' . $error . '</li>';
        }
        print '</ul>';
        print '</div>';
    } else {  
        if ((md5($oldPass) == $user['parola'])) {
            if ((md5($newPass) === md5($newPassConfirm))) {
                if (isset($_FILES['image'])) {
                    if ($_FILES['image']['error'] == 0) {
                        switch ($_FILES['image']['type']) {
                            case 'image/jpg';
                            case 'image/jpeg';
                            case 'image/png';
                            case 'image/bmp';
                            case 'image/gif';
                                $profilePicture = uniqid() . $_FILES['image']['name'];
                                $moveProfilePicture = move_uploaded_file($_FILES['image']['tmp_name'], 'imagini/' . $profilePicture);
                                if ($moveProfilePicture) {
                                    $updateUserCredentials = updateUserCredentials($newLastName, $newFirstName, $_SESSION['user'], $newPass, $profilePicture);
                                    if ($updateUserCredentials) {
                                        if (!empty($user['poza_profil'])) {
                                            unlink('imagini/' . $produs['poza_profil']);
                                        }
                                        print "<script>alert('Felicitări! Datele dumneavoastră au fost actualizate cu succes!')</script>";
                                        header("location: index.php?page=2");
                                    } else {
                                        unlink('imagini/' . $profilePicture);
                                        print 'Eroare la salvarea pozei de profil!';
                                    }
                                } else {
                                    print 'Eroare la salvarea pe server!';
                                }
                                break;
                            default:
                                print 'Fișierul selectat nu are un format acceptat!';
                                break;
                        }
                    } elseif ($_FILES['image']['error'] == 4) {
                        $updateUserCredentials = updateUserCredentials($newLastName, $newFirstName, $_SESSION['user'], $newPass);
                        if ($updateUserCredentials) {
                            print "<script>alert('Felicitări! Datele dumneavoastră au fost actualizate cu succes!')</script>";
                            header("location: index.php?page=2");
                        } else {
                            print 'Eroare la actualizarea datelor de contact!';
                        }
                    } else {
                        print 'Eroare la salvarea pozei de profil!';
                    }
                } else {
                    $updateUserCredentials = updateUserCredentials($newLastName, $newFirstName, $_SESSION['user'], $newPass, NULL);
                    print $updateUserCredentials ? 'Datele au fost actualizate cu succes!' : 'Eroare la actualizarea datelor de contact!';
                }
            } else {
                print "<script>alert('Oops! Parolele nu se potrivesc! Parola nouă cu corespunde cu parola confirmată.')</script>";
            }
        } else {
            print "<script>alert('Parola actuala nu este cea corectă! Vă rugăm reîncercați!')</script>";
        }
    } 
}