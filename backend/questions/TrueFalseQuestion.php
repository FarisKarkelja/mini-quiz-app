<?php
require_once __DIR__ . '/Question.php';

class TrueFalseQuestion extends Question {
    private string $correctAnswer;

    public function __construct(array $data) {
        parent::__construct($data);
        $this->correctAnswer = $data['correctAnswer']; 
    }

    public function render(): array {
        return [
            'id'   => $this->id,
            'text' => $this->text,
            'type' => $this->type
        ];
    }

    public function grade($userAnswer): bool {
        return strtolower(trim($userAnswer)) === $this->correctAnswer;
    }

    public function toView(): array {
        return $this->render();
    }
}