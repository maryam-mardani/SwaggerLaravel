<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

use function App\Helpers\failedResponse;
use function App\Helpers\successResponse;

class AuthController extends Controller
{

    /**
     * @OA\Post(path="/api/auth/login",
     *     tags={"User"},
     *     summary="Login user into the system",
     *     description="",
     *     operationId="loginUser",
     *     @OA\Parameter(name="username",required=true,in="query",description="The user name for login",@OA\Schema(type="string")),
     *     @OA\Parameter(name="password",in="query",required=true,@OA\Schema(type="string"),description="The password for login in clear text"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(type="string"),
     *         @OA\Header(header="X-Rate-Limit",@OA\Schema(type="integer",format="int32"),description="calls per hour allowed by the user"),
     *     ),
     *     @OA\Response( response=404,description="invalid data",@OA\JsonContent()),
     *     @OA\Response(response=500,description="internal server error",@OA\JsonContent()),
     *     @OA\Response(response=400, description="Invalid username/password supplied")
     * )
     */

    function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepository::FindByField("username", $request->username);
        if (!$user) {
            return failedResponse(__("common.notFound"), ResponseCode::NOT_FOUND_DATA);
        }
        if (!Hash::check($request->password, $user->password)) {
            return failedResponse(__("common.notFound"), ResponseCode::NOT_FOUND_DATA);
        }
        $token = $user->createToken('authTokenUser')->plainTextToken;
        $user['token'] = $token;

        return  successResponse($user);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/logout",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response( response=404,description="invalid data",@OA\JsonContent()),
     *     @OA\Response(response=500,description="internal server error",@OA\JsonContent()),
     *     @OA\Response(response="200", description="An example resource",@OA\JsonContent()),
     * )
     */
     function logout(): JsonResponse
     {
         auth()->user()->tokens()->delete();
         return  successResponse([]);
     }
}
