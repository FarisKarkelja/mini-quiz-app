<?php
require_once __DIR__ . '/GradingStrategy.php';

class PercentageGrade implements GradingStrategy {
    public function calculate(array $results, int $totalQuestions): array {
        $correct = count(array_filter($results)); 
        $percentage = ($totalQuestions > 0) ? round(($correct / $totalQuestions) * 100) : 0;
        return [
            'score'      => $correct,
            'total'      => $totalQuestions,
            'percentage' => $percentage,
            'passed'     => $percentage >= 50   
        ];
    }
}