<?php
/*
Utilizator – id PK, nume, prenume, email, parola, poza_profil default NULL
Task – id Pk, titlu, data, tip, descriere, status (0 – in asteptare, 1 - terminat), id_utilizator FK
 */
function connectDB(
                  $host = 'localhost',
                  $username = 'root',
                  $password = '',
                  $database = 'agenda'
                  )
{
    return mysqli_connect($host, $username, $password, $database);
} //ok

function getUserByEmail($emailAdress) 
{
    $link = connectDB();
    $query = "SELECT * FROM utilizator WHERE email = '$emailAdress'";
    $result = mysqli_query($link, $query);
    $username = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    return $username;
} //ok

function clearData($input, $link)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    $input = mysqli_real_escape_string($link, $input);
    
    return $input;
} //ok

function registerUser($lastName, $firstName, $email, $password)
{
    $link = connectDB();
    $lastName = clearData($lastName, $link);
    $firstName = clearData($firstName, $link);
    $email = clearData($email, $link);
    $password = clearData($password, $link);
    $password = md5($password);
    
    $user = getUserByEmail($email);
    
    if ($user) {
        return false;
    }
    
    $query = "INSERT INTO utilizator VALUES(NULL, '$lastName', '$firstName', '$email', '$password', NULL)";
    return mysqli_query($link, $query);
} //ok

function connectUser($email, $password)
{
    $link = connectDB();
    $email = clearData($email, $link);
    $password = clearData($password, $link);
    
    $user = getUserByEmail($email);
    if ($user) {
        return md5($password) == $user['parola'];
    }
} //ok

function updateUserCredentials($newLastName, $newFirstName, $email, $newPassword, $profilePicture = NULL)
{
    $link = connectDB();
    $newLastName = clearData($newLastName, $link);
    $newFirstName = clearData($newFirstName, $link);
    $newPassword = clearData($newPassword, $link);
    $newPassword = md5($newPassword);
    $profilePicture = clearData($profilePicture, $link);
    
    if (!empty($profilePicture)) {
        $query = "UPDATE utilizator SET nume ='$newLastName', prenume ='$newFirstName', parola ='$newPassword', poza_profil ='$profilePicture' WHERE email ='$email'";
    } else {
        $query = "UPDATE utilizator SET nume ='$newLastName', prenume ='$newFirstName', parola ='$newPassword' WHERE email ='$email'";
    }
    
    return mysqli_query($link, $query);
} //ok

function updateProfilePicture($email, $profilePicture)
{
    $link = connectDB();
    $profilePicture = clearData($profilePicture, $link);
    
    $query = "UPDATE utilizator SET poza_profil ='$profilePicture' WHERE email ='$email'";
    
    return mysqli_query($link, $query);
} //ok

function addTask($title, $date, $type, $description, $userId) {
    $link = connectDB();
    $title = clearData($title, $link);
    $date = clearData($date, $link);
    $type = clearData($type, $link);
    $description = clearData($description, $link);
    
    $query = "INSERT INTO task(titlu, data, tip, descriere, id_utilizator) VALUES('$title','$date','$type','$description', $userId)";
    
    return mysqli_query($link, $query);
    
}//ok

function showActiveTasks($userId) {
    $link = connectDB();

    $query = "SELECT * FROM task WHERE id_utilizator = $userId AND status = '0' ORDER BY data";
    $result = mysqli_query($link, $query);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;
} //ok

function filterActiveTasks($userId, $sortCriteria) {
    $link = connectDB();
    
    if ($sortCriteria == 'toatetaskurile') {
        $query = "SELECT * FROM task WHERE id_utilizator = $userId AND status = '0' ORDER BY data";
    } else {
        $query = "SELECT * FROM task WHERE id_utilizator = $userId AND status = '0' AND tip = '$sortCriteria' ORDER BY data";
    }
    
    $result = mysqli_query($link, $query);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;
} //ok

function completeTask($idTask, $userId) {
    $link = connectDB();

    $query = "UPDATE task SET status = '1' WHERE id ='$idTask' AND id_utilizator = '$userId'";

    return mysqli_query($link, $query);
} //ok

function showCompletedTasks($userId) {
    $link = connectDB();

    $query = "SELECT * FROM task WHERE id_utilizator = $userId AND status = '1' ORDER BY data";
    $result = mysqli_query($link, $query);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $tasks;
} //ok

function deleteTask($taskId)
{
    $link = connectDB();
    $query = "DELETE FROM task WHERE id = $taskId";
    
    return mysqli_query($link, $query);
} //ok