<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');         
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/QuizFacade.php';

$quiz = new QuizFacade(__DIR__ . '/../data/questions.json');

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'GET' && $uri === '/api/questions') {
    echo json_encode($quiz->getQuestions());

} elseif ($method === 'POST' && $uri === '/api/submit') {
    $input = json_decode(file_get_contents('php://input'), true);
    $answers = $input['answers'] ?? [];
    $result = $quiz->submit($answers);
    echo json_encode($result);

} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}