<?php

namespace App\Constants;

interface TweetConstants
{
    const VALID = 'VALID';
    const INVALID = 'INVALID';
    const STATUS = [
        'VALID', 'INVALID'
    ];

    const CREATE_RULES = [
        'body'  => 'required',
        'tags'  => 'required|exists:tags,id'
    ];

    const UPDATE_RULES = [
        'body' => 'required',
        'tags' => 'required'
    ];
}
