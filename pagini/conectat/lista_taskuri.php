<?php 

$userId = getUserByEmail($_SESSION['user']);
$allActiveTasks = showActiveTasks($userId['id']);

if (count($allActiveTasks) == 0) {
    print '<b>Nu aveți evenimente viitoare! Puteți adăuga o activitate <a href="index.php">aici</a>.</b>';
} else {
    $sortCriteria = $_POST['sort-criteria'];
?>
    <form class="row g-3" method="post">
        <div class="col-auto">
            <select name="sort-criteria" class="form-select">
                <option value="toatetaskurile" <?php if ($sortCriteria == 'toatetaskurile') print 'selected' ?> >Toate activitățile</option>
                <option value="task" <?php if ($sortCriteria == 'task') print 'selected' ?> >Sarcină de lucru</option>
                <option value="eveniment" <?php if ($sortCriteria == 'eveniment') print 'selected' ?> >Eveniment</option>
                <option value="reminder" <?php if ($sortCriteria == 'reminder') print 'selected' ?> >Reminder</option>
            </select>
        </div>
        <div class="col-auto">
        <button type="submit" name="sort" class="btn btn-primary">Filtrează</button>
        </div>
    </form><br>

    <?php
    if (isset($sortCriteria)) {
        $filteredTasks = filterActiveTasks($userId['id'], $sortCriteria);
        if (count($filteredTasks) == 0) {
            print 'Nu există sarcini active în această categorie.';
        } else {
?>
            <h3>Activități active din această categorie: <?php print count($filteredTasks)?>.</h3>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Titlu</th>
                    <th>Data</th>
                    <th>Tip</th>
                    <th>Descriere</th>
                    <th>Marchează ca finalizat</th>
                </tr>
<?php
            foreach ($filteredTasks as $fTask) {
?>
                <tr>
                    <td><?php print $fTask['titlu']; ?></td>
                    <td><?php print $fTask['data']; ?></td>
                    <td><?php  
                            if ($fTask['tip'] == 'task') {
                                    print 'Sarcină de lucru';
                                } elseif ($fTask['tip'] == 'eveniment') {
                                    print 'Eveniment';
                                } else {
                                    print 'Reminder';
                                }
                        ?>
                    </td>
                    <td><?php print $fTask['descriere']; ?></td>
                    <td><a class="btn btn-success" href="index.php?page=1&finalizeaza=<?php print $fTask['id']; ?> " >Finalizare task</a></td>
                </tr>
<?php
            }
        }
    } else {
?>
        <h3>Activități active din această categorie: <?php print count($allActiveTasks)?>.</h3>
        <table class="table table-striped table-hover">
            <tr>
                <th>Titlu</th>
                <th>Data</th>
                <th>Tip</th>
                <th>Descriere</th>
                <th>Marchează ca finalizat</th>
            </tr>

            <?php
            foreach ($allActiveTasks as $task) {
                ?>
                <tr>
                    <td><?php print $task['titlu']; ?></td>
                    <td><?php print $task['data']; ?></td>
                    <td><?php  
                            if ($task['tip'] == 'task') {
                                    print 'Sarcină de lucru';
                                } elseif ($task['tip'] == 'eveniment') {
                                    print 'Eveniment';
                                } else {
                                    print 'Reminder';
                                }
                        ?>
                    </td>
                    <td><?php print $task['descriere']; ?></td>
                    <td><a class="btn btn-success" href="index.php?page=1&finalizeaza=<?php print $task['id']; ?>">Finalizare task</a></td>
                </tr>
<?php
            }
    }
}
?>
        </table><br>
        <div class="wrapper">
	<div class="divider div-transparent"></div>
        </div>

<?php

if (isset($_GET['finalizeaza'])) {
    $idTask = $_GET['finalizeaza'];
    $user = getUserByEmail($_SESSION['user']);
    $userId = $user['id'];
    $completeTask = completeTask($idTask, $userId);
    if ($completeTask) {
        header('location: index.php?page=1');
    } else {
        print 'Eroare la finalizarea taskului';
    }
}

$allCompletedTasks = showCompletedTasks($userId['id']);

if (count($allCompletedTasks) == 0) {
    echo "<b>Nu aveți evenimente finalizate!</b>";
} else {
    ?>
    <h3>Activități finalizate: <?php echo count($allCompletedTasks)?>.</h3>

    <form method="post" enctype="multipart/form-data" style="margin: 0 auto;">
        <table class="table table-striped table-hover">
            <tr>
                <th>Titlu</th>
                <th>Data</th>
                <th>Tip</th>
                <th>Descriere</th>
                <th>Elimină task</th>
            </tr>

            <?php
            foreach ($allCompletedTasks as $task) {
                ?>
                <tr>
                    <td><?php print $task['titlu']; ?></td>
                    <td><?php print $task['data']; ?></td>
                    <td><?php  
                            if ($task['tip'] == 'task') {
                                    print 'Sarcină de lucru';
                                } elseif ($task['tip'] == 'eveniment') {
                                    print 'Eveniment';
                                } else {
                                    print 'Reminder';
                                }
                        ?>
                    </td>
                    <td><?php print $task['descriere']; ?></td>
                    <td><a class="btn btn-danger" href="index.php?page=1&sterge=<?php print $task['id']; ?>">Ștergere task</a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</form>  

<?php

if (isset($_GET['sterge'])) {
    $idTask = $_GET['sterge'];
    $deleteTask = deleteTask($idTask);
    if ($deleteTask) {
        header('location: index.php?page=1');
    } else {
        print 'Eroare la ștergerea taskului';
    }
}

?>

