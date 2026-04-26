<?php

class FAQ {
    private $question;
    private $answer;
    private $category;

    public function __construct($question, $answer, $category) {
        $this->question = $question;
        $this->answer = $answer;
        $this->category = $category;
    }

    public function getQuestion() { return $this->question; }
    public function getAnswer() { return $this->answer; }
    public function getCategory() { return $this->category; }

    public function setQuestion($q) { $this->question = $q; }
    public function setAnswer($a) { $this->answer = $a; }
}
