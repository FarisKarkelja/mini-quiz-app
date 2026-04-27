<?php
require_once __DIR__ . '/GradingStrategy.php';

class PassFail implements GradingStrategy {
    public function calculate(array $results, int $totalQuestions): array {
        $correct = count(array_filter($results));
        $passed = $correct >= ($totalQuestions / 2); 
        return [
            'score'  => $correct,
            'total'  => $totalQuestions,
            'passed' => $passed,
            'result' => $passed ? 'Pass' : 'Fail'
        ];
    }
}