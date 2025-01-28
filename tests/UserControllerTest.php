<?php

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase {
    private $db;
    private $redis;
    private $userModel;
    private $userController;

    protected function setUp(): void {
        $this->db = new PDO('mysql:host=localhost;dbname=assignment', 'root', '');
        $this->redis = new RedisCache();
        $this->userModel = new User($this->db);
        $this->userController = new UserController($this->userModel, $this->redis);
    }

    public function testCreateUser() {
        $response = $this->userController->createUser('Nazar Ali', 'nazar.ali@yahoo.com');
        $this->assertArrayHasKey('id', $response['data']);
    }

    public function testGetUser() {
        $response = $this->userController->getUserById(1);
        $this->assertEquals('Nazar Ali', $response['data']['name']);
    }
}
