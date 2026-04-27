<?php
require_once __DIR__ . '/Question.php';

class MultipleChoiceQuestion extends Question {
    private $options;
    private $correctAnswer;

    public function __construct(array $data) {
        parent::__construct($data);
        $this->options       = $data['options'];
        $this->correctAnswer = $data['correctAnswer']; 
    }

    public function render(): array {
        return [
            'id'      => $this->id,
            'text'    => $this->text,
            'type'    => $this->type,
            'options' => $this->options
        ];
    }

    public function grade($userAnswer): bool {
        return (int)$userAnswer === $this->correctAnswer;
    }

    public function toView(): array {
        return $this->render(); 
    }
}