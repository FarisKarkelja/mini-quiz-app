<?php
require_once __DIR__ . '/questions/Question.php';
require_once __DIR__ . '/questions/MultipleChoiceQuestion.php';

class QuestionFactory {
    public static function create(array $data): Question {
    switch ($data['type']) {
        case 'multiple_choice':
            return new MultipleChoiceQuestion($data);
        case 'true_false':
            require_once __DIR__ . '/questions/TrueFalseQuestion.php';
            return new TrueFalseQuestion($data);
        case 'short_answer':
            require_once __DIR__ . '/questions/ShortAnswerQuestion.php';
            return new ShortAnswerQuestion($data);
        default:
            throw new \InvalidArgumentException("Unsupported question type: {$data['type']}");
    }
}
}