<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class FrontendTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:update,tag')->only('edit');
    }

    public function index()
    {
        $tags = Tag::with('creator')->latest()->paginate(15);
        return view('frontend.tags.index', compact(['tags']));
    }

    public function show(int $id)
    {
        $tag = Tag::with('creator')->findOrFail($id);
        $questions = $tag->questions()->latest()->paginate(3);
        return view('frontend.tags.show', compact(['tag', 'questions']));
    }

    public function create()
    {
        return view('frontend.tags.create');
    }

    public function edit(Tag $tag)
    {
        return view('frontend.tags.edit', compact(['tag']));
    }

}
