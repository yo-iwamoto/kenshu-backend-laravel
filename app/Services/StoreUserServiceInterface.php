<?php

namespace App\Services;

use Illuminate\Http\Request;

interface StoreUserServiceInterface
{
    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function execute(Request $request);
}
