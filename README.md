# Mini Quiz App

A small web application that presents a 10-question quiz on design patterns. Users can answer multiple‑choice, true/false, and short‑answer questions and get a final score calculated by a swappable grading strategy.

**Tech stack:** PHP (backend), Vanilla JavaScript (frontend), JSON file (persistence), HTML/CSS.

**Connection to Lab 5–7:** I analyzed **Sakai LMS** in Labs 5–7 (category: **Learning Management System / Course Platform**). I am building a **Mini Quiz App**, which belongs to the same category.

## Patterns Applied

| Pattern (Category)              | Files & Classes                                                              | Problem it solves in this app                                                                                                                                                                                                                                                   |
| ------------------------------- | ---------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Factory Method** (Creational) | `backend/QuestionFactory.php` – `QuestionFactory::create()`                  | Avoids hardcoded `new MultipleChoiceQuestion()` scattered in loading code. Makes it easy to add new question types (TrueFalse, ShortAnswer) later — a weakness I identified in Sakai’s quiz engine where question types were created with a giant switch inside the controller. |
| **Facade** (Structural)         | `backend/QuizFacade.php` – `QuizFacade` class                                | Hides the complexity of loading JSON, creating question objects, grading, and strategy selection behind two simple methods (`getQuestions()`, `submit()`). The frontend only talks to the facade. This is exactly the kind of simplification Sakai’s enrollment system lacked.  |
| **Strategy** (Behavioral)       | `backend/grading/GradingStrategy.php`, `PercentageGrade.php`, `PassFail.php` | Allows swapping grading algorithms (percentage vs. pass/fail) without modifying the quiz logic. In Sakai, grading was often a monolithic `if/else` inside the quiz result page — here it’s cleanly separated and testable.                                                      |
