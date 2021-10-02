<!--meniu cu home, conectare, inregistrare
sablonare pt paginile din meniu -->
<nav id="meniu">
    <ul>
        <li><a href="index.php"><i class="fas fa-home"></i>&nbsp;Acasă</a></li>
        <li><a href="index.php?page=1"><i class="fas fa-arrow-alt-circle-right"></i>&nbsp;Conectare</a></li>
        <li><a href="index.php?page=2"><i class="fas fa-arrow-alt-circle-up"></i>&nbsp;Înregistrare</a></li>
    </ul>
</nav>

<section id="continut">
<?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page == 1) {
            require_once 'pagini/neconectat/conectare.php';
        } elseif ($page == 2)  {
            require_once 'pagini/neconectat/inregistrare.php';
        } else {
            require_once 'pagini/eroare.php';
        }
    } else {
        require_once 'pagini/neconectat/home.php';
    } 
?>
</section>
<footer class="footer pt-3 mt-4 border-top">&copy;2021 MIHAIL Alexandru-Ionuț - PROIECT Web Development Fundamentals - PHP/MySQL</footer>