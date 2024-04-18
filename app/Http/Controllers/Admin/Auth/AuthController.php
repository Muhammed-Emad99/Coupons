<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Base\Responses\apiResponse;
use App\Http\Requests\Admin\Auth\CreateRequest;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    use apiResponse;


    public function login(LoginRequest $request)
    {
        $cerdentials = $request->only(['email', 'role', 'password']);

        $attempt = Auth::attempt($cerdentials, true);

        if ($attempt) {
            $user = User::where('email', $request->email)->where('role', 'Admin')->first();
            return $this->success(
                'Login successfully.',
                [
                    'user' => new UserResource($user),
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ]);
        } else {
            return $this->fail('Invalid credentials.', ["not-correct" => ['email or password is not correct']]);
        }

    }

    public function createUser(CreateRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return $this->success('User created successfully.', new UserResource($user));

    }

    public function getUserByID($id)
    {
        $user = User::find($id);
        if ($user) {

            return $this->success('Get User data successfully.', new UserResource($user));
        }

        return $this->fail('User not found.', [], Response::HTTP_NOT_FOUND);

    }

}
