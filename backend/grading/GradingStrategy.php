<?php
interface GradingStrategy {
    public function calculate(array $results, int $totalQuestions): array;
}