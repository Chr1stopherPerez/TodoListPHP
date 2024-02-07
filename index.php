<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ajouter une tâche
if (isset($_POST['addTask'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    $conn->query($sql);
}

// Supprimer une tâche
if (isset($_GET['deleteTask'])) {
    $id = $_GET['deleteTask'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
}

// Mettre à jour l'état de la tâche (cocher/décocher)
if (isset($_GET['updateTask'])) {
    $id = $_GET['updateTask'];
    $sql = "UPDATE tasks SET completed = 1 - completed WHERE id=$id";
    $conn->query($sql);
}

// Récupérer la liste des tâches
$sql = "SELECT * FROM tasks ORDER BY id ASC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>TodoList PHP</title>
    <!-- FAVICON -->
    <link rel="icon" href="favicon.png">

</head>

<body>

    <h2>Ma TODO LISTE</h2>

    <form method="post" action="">
        <input type="text" name="task" required>
        <button type="submit" name="addTask">AJOUTER</button>
    </form>

    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            $completedClass = ($row['completed'] == 1) ? 'completed' : '';
            echo "<li class='$completedClass'>";
            echo "<input type='checkbox' onclick='updateTask({$row['id']})' " . ($row['completed'] == 1 ? 'checked' : '') . ">";
            echo "{$row['task']} ";
            echo "<a href='?deleteTask={$row['id']}'>SUPPRIMER</a>";
            echo "</li>";
        }
        ?>
    </ul>

    <script>
        function updateTask(id) {
            window.location.href = '?updateTask=' + id;
        }
    </script>

</body>

</html>

<!-- Index.php -->