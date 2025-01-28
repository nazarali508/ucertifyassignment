<?php
require_once 'config/db.php';
require_once 'config/redis.php';
require_once 'config/response.php';
require_once 'models/User.php';
require_once 'controllers/UserController.php';

$db = new PDO('mysql:host=localhost;dbname=assignment', 'root', '');
$redis = new RedisCache();
$userModel = new User($db);
$userController = new UserController($userModel, $redis);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

switch ($requestMethod) {
    case 'GET':
        if (isset($uri[1])) {
            $userController->getUserById($uri[1]);
        } else {
            $userController->getAllUsers();
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $userController->createUser($data['name'], $data['email']);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $userController->updateUser($uri[1], $data['name'], $data['email']);
        break;
    case 'DELETE':
        $userController->deleteUser($uri[1]);
        break;
    default:
        Response::error('Method not allowed', 405);
}
