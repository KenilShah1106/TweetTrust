<?php

namespace App\Constants;

interface QuestionConstants
{
    const CREATE_RULES = [
        'title' => 'required|unique:questions|max:255',
        'body'  => 'required',
        'tags'  => 'required|exists:tags,id'
    ];

    const UPDATE_RULES = [
        'body' => 'required',
        'tags' => 'required'
    ];
}
