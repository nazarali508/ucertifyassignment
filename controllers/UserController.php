<?php
class UserController {
    private $userModel;
    private $cache;

    public function __construct($userModel, $cache) {
        $this->userModel = $userModel;
        $this->cache = $cache;
    }

    public function getAllUsers() {
        $cachedUsers = $this->cache->get('users_all');
        if ($cachedUsers) {
            Response::success('Users fetched from cache', json_decode($cachedUsers, true));
        }

        $users = $this->userModel->getAll();
        $this->cache->set('users_all', json_encode($users));
        Response::success('Users fetched successfully', $users);
    }

    public function getUserById($id) {
        $user = $this->userModel->getById($id);
        if (!$user) {
            Response::error('User not found', 404);
        }
        Response::success('User fetched successfully', $user);
    }

    public function createUser($name, $email) {
        $userId = $this->userModel->create($name, $email);
        Response::success('User created successfully', ['id' => $userId]);
    }

    public function updateUser($id, $name, $email) {
        $this->userModel->update($id, $name, $email);
        Response::success('User updated successfully');
    }

    public function deleteUser($id) {
        $this->userModel->delete($id);
        Response::success('User deleted successfully');
    }
}
