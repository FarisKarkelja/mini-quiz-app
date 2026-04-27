<?php
require_once __DIR__ . '/QuestionFactory.php';
require_once __DIR__ . '/grading/GradingStrategy.php';
require_once __DIR__ . '/grading/PercentageGrade.php';

class QuizFacade {
    private string $jsonPath;
    private GradingStrategy $strategy;

    public function __construct(string $jsonPath, ?GradingStrategy $strategy = null) {
        $this->jsonPath = $jsonPath;
        $this->strategy = $strategy ?? new PercentageGrade();
    }

    public function getQuestions(): array {
        $raw = json_decode(file_get_contents($this->jsonPath), true);
        if (!$raw) {
            return [];
        }
        $questions = [];
        foreach ($raw as $item) {
            $questions[] = QuestionFactory::create($item);
        }
        return array_map(function(Question $q) {
            return $q->toView();
        }, $questions);
    }

    public function submit(array $answers): array {
        $raw = json_decode(file_get_contents($this->jsonPath), true);
        $results = []; 
        foreach ($raw as $item) {
            $question = QuestionFactory::create($item);
            $userAnswer = $answers[$question->getId()] ?? null;
            $results[] = $question->grade($userAnswer);
        }
        return $this->strategy->calculate($results, count($raw));
    }
}