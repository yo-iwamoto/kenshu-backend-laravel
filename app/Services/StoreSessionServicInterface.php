<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

interface StoreSessionServicInterface
{
    /**
     * @param Request $request
     * @return bool Auth::attempt の返り値
     * @throws ValidationException
     */
    public function execute(Request $request);
}
