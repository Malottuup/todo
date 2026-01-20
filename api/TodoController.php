<?php

namespace Todo\Api;

use OpenApi\Annotations as OA;
use mysqli;

/**
 * @OA\Tag(
 *   name="Tasks",
 *   description="Управление задачами"
 * )
 */
class TodoController
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = new mysqli("MySQL-8.0", "root", "", "todo_db");
        $this->db->set_charset("utf8");
    }

    /**
     * @OA\Get(
     *   path="/api/tasks",
     *   tags={"Tasks"},
     *   summary="Получить список задач",
     *   @OA\Response(
     *     response=200,
     *     description="OK"
     *   )
     * )
     */
    public function list(): array
    {
        $res = $this->db->query("SELECT * FROM tasks ORDER BY id DESC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @OA\Post(
     *   path="/api/tasks",
     *   tags={"Tasks"},
     *   summary="Создать задачу",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"task"},
     *       @OA\Property(property="task", type="string", example="Купить хлеб")
     *     )
     *   ),
     *   @OA\Response(response=200, description="Создано")
     * )
     */
    public function create(array $data): array
    {
        $task = trim($data['task'] ?? '');

        if ($task === '') {
            http_response_code(400);
            return ['error' => 'Task required'];
        }

        $stmt = $this->db->prepare("INSERT INTO tasks (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        $stmt->execute();

        return ['id' => $stmt->insert_id, 'task' => $task];
    }
}
