<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Validation;
use App\Notifications\ValidationCodeSent;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws RandomException
     */
    public function __invoke(RegisterRequest $request): UserResource
    {
        $userCreated = User::query()->create($request->validated());
        Auth::login($userCreated);
        $userCreated->profile()->create([
            'username' => $userCreated->first_name . ' ' . $userCreated->last_name,
        ]);
        return new UserResource($userCreated);
    }
}
