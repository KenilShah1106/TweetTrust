<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use App\Services\QuestionService;

class FrontendQuestionsController extends Controller
{
    private $questionService;
    public function __construct()
    {
        $this->middleware('can:performAuthorActions,question')->only('edit');
        $this->questionService = new QuestionService();
    }
    public function index()
    {
        $questions = $this->questionService->index();
        return view('frontend.questions.index', compact(['questions']));
    }

    public function show(int $id)
    {
        $question = $this->questionService->show($id);
        return view('frontend.questions.show', compact(['question']));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('frontend.questions.create', compact(['tags']));
    }

    public function edit(Question $question)
    {
        $tags = Tag::all();
        return view('frontend.questions.edit', compact(['question', 'tags']));
    }

}
