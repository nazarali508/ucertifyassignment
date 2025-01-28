<?php
class Response {
    public static function send($data, $statusCode = 200) {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    public static function success($message, $data = []) {
        self::send([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function error($message, $statusCode = 400) {
        self::send([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
