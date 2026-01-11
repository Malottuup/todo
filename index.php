<?php
$mysqli = new mysqli("MySQL-8.0:3306", "root", "", "todo_db");
$result = $mysqli->query("SELECT * FROM tasks ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>ToDo List</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
<h1>ToDo List</h1>
<form id="taskForm">
<input type="text" id="taskInput" required>
<button type="submit">Добавить</button>
</form>
<ul id="taskList">
<?php while ($row = $result->fetch_assoc()): ?>
<li data-id="<?= $row['id'] ?>" class="<?= $row['is_completed'] ? 'done' : '' ?>">
<input type="checkbox" class="toggle" <?= $row['is_completed'] ? 'checked' : '' ?>>
<span><?= htmlspecialchars($row['task']) ?></span>
<button class="delete">✕</button>
</li>
<?php endwhile; ?>
</ul>
</div>
<script src="script.js"></script>
</body>
</html>