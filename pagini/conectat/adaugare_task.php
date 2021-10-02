<form method="post" class="add-activity shadow-sm p-3 mb-5 bg-white rounded">
    <h3 style="text-align:center;"">Formular de adăugare activitate:</h3>
    <div class="mb-3">
        <label for="title">Titlul:</label>
        <input required type="text" name="title" id="title" class="form-control" placeholder="Un titlu pentru activitatea dumneavoastră..."/>
    </div>
    <div class="mb-3">
        <label for="date">Data activității:</label>
        <input required type="date" name="date" id="date" class="form-control"/>
    </div>
    <div class="mb-3">
        <label for="activity-type">Tipul acesteia:</label>
        <select required type="text" name="activity-type" id="activity-type" class="form-select">
                    <option value="task">Sarcină de lucru</option>
                    <option value="eveniment">Eveniment</option>
                    <option value="reminder">Reminder</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="description">Descrierea:</label>
        <textarea required name="description" id="description" class="form-control" rows="6" placeholder="Descrierea activității dumneavoastră..."></textarea>          
    </div>
    <button type="submit" name="taskSubmit" class="btn btn-primary">Adaugă activitate</button>
</form>

<?php
if (isset($_POST['taskSubmit'])) {
    $titleOfActivity = $_POST['title'];
    $dateOfActivity = $_POST['date'];
    $typeOfActivity = $_POST['activity-type'];
    $activityDescription = $_POST['description'];
    $user = getUserByEmail($_SESSION['user']);
    $userId = $user['id'];
    
    $addTask = addTask($titleOfActivity, $dateOfActivity, $typeOfActivity, $activityDescription, $userId);

    if ($addTask) {
        echo '<script>alert("Activitatea a fost înregistrată cu succes!")</script>';
    } else {
        echo '<script>alert("Eroare la înregistrarea activității!")</script>';
    }
}

