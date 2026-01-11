<?php
header('Content-Type: application/json');
$mysqli = new mysqli("MySQL-8.0:3306", "root", "", "todo_db");
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
$task = trim($_POST['task'] ?? '');
if ($task !== '') {
$stmt = $mysqli->prepare("INSERT INTO tasks (task) VALUES (?)");
$stmt->bind_param("s", $task);
$stmt->execute();
echo json_encode(['id' => $stmt->insert_id, 'task' => $task]);
}
exit;
}
parse_str(file_get_contents("php://input"), $data);
if ($method === 'DELETE') {
$id = (int)$data['id'];
$mysqli->query("DELETE FROM tasks WHERE id=$id");
echo json_encode(['success' => true]);
exit;
}
if ($method === 'PUT') {
$id = (int)$data['id'];
$is_completed = (int)$data['is_completed'];
$mysqli->query("UPDATE tasks SET is_completed=$is_completed WHERE id=$id");
echo json_encode(['success' => true]);
exit;
}