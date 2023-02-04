<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class Utils
{
    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public static function validateOrThrow(array $validationRules, array $data): array
    {
        $validator = Validator::make($data, $validationRules);
        throw_if($validator->fails(), ValidationException::withMessages($validator->getMessageBag()->toArray()));
        return $validator->validated();
    }
}
