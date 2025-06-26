<?php
namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::query()->whereEmail($credentials['email'])->firstOrFail();
            $request->session()->regenerate();
            return UserResource::make($user);
        }
        
        throw new ValidationException(
            [
                "email" => "wrongs credentials provided"
            ]
            );
    }
}
