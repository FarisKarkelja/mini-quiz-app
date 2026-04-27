<?php
abstract class Question {
    protected $id;
    protected $text;
    protected $type;

    public function __construct(array $data) {
        $this->id   = $data['id'];
        $this->text = $data['text'];
        $this->type = $data['type'];
    }

    abstract public function render(): array;

    abstract public function grade($userAnswer): bool;

    abstract public function toView(): array;

    public function getId() { return $this->id; }
    public function getText() { return $this->text; }
    public function getType() { return $this->type; }
}