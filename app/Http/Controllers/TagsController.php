<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:update,tag')->only('update');
        $this->middleware('can:delete,tag')->only('delete');
    }

    public function store(CreateTagRequest $request)
    {
        auth()->user()->tags()->create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);
        return redirect(route('frontend.tags.index'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name,
            'desc' => $request->desc
        ]);
        return redirect(route('frontend.tags.show', $tag->id));
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('frontend.tags.index'));
    }
}
