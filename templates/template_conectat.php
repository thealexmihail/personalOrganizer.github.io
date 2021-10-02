<!--meniu cu adaugare task, lista taskuri, vizualizare profil, deconectare
sablonare pt paginile din meniu, nu intra si deconectare aici la sablonare -->
<nav id="meniu">
    <ul>
        <li><a href="index.php"><i class="far fa-calendar-plus"></i>&nbsp;Adaugă task</a></li>
        <li><a href="index.php?page=1"><i class="fas fa-tasks"></i>&nbsp;Listă task-uri</a></li>
        <li><a href="index.php?page=2"><i class="fas fa-address-card"></i>&nbsp;Profilul meu</a></li>
        <li><a href="index.php?logout"><i class="fas fa-door-open"></i>&nbsp;Deconectare</a></li>
    </ul>
</nav>

<section id="continut">
<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("location: index.php");
}

if (isset($_SESSION['welcome'])) {
    print $_SESSION['welcome'];
    unset ($_SESSION['welcome']);
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 1) {
        require_once 'pagini/conectat/lista_taskuri.php';
    } elseif ($page == 2) {
        require_once 'pagini/conectat/vizualizare_profil.php';
    } else {
        require_once 'pagini/eroare.php';
    }
} else {
    require_once 'pagini/conectat/adaugare_task.php';
}
?>
</section>
<footer class="footer pt-3 mt-4 border-top">&copy;2021 MIHAIL Alexandru-Ionuț - PROIECT Web Development Fundamentals - PHP/MySQL</footer>