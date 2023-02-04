<?php

namespace App\Http\Controllers;

use App\DTO\Questions\QuestionDTO;
use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Notifications\Questions\NewQuestionAdded;
use App\Services\QuestionService;
use Exception;

class QuestionsController extends Controller
{
    public function __construct(private QuestionService $questionService)
    {
        $this->middleware('can:performAuthorActions,question')->except('store');
    }
    public function store(CreateQuestionRequest $request)
    {
        try {
            $question = $this->questionService->store(new QuestionDTO(
                title: $request->title,
                body: $request->body,
                user_id: auth()->id(),
                tags: $request->tags,
            ));
            /** Send Notifications */
            $userMsg = "You question has been successfully posted!";
            auth()->user()->notify(new NewQuestionAdded($question, $userMsg));

            return redirect(route('frontend.questions.index'));
        } catch(Exception $e) {
            session()->flash('error', 'Some unexpected error' . $e);
            return redirect()->back();
        }
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        try {
            $this->questionService->update(new QuestionDTO(
                title: $request->title,
                body: $request->body,
                tags: $request->tags,
            ), $question);
            return redirect(route('frontend.questions.show', $question->id));
        } catch(Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect(route('frontend.questions.index'));
    }
    public function markAsBestAnswer(Question $question, Answer $answer)
    {
        try {
            $this->questionService->markAsBestAnswer($question, $answer);
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
