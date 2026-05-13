<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/login",
        summary: "Login ke sistem",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login berhasil"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function login(Request $request) {
        $request->validate(["email" => "required|email", "password" => "required"]);
        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Unauthorized"], 401);
        }
        return response()->json(["token" => $user->createToken("auth_token")->plainTextToken], 200);
    }

    #[OA\Post(
        path: "/api/register",
        summary: "Register user baru",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string", minLength: 8),
                    new OA\Property(property: "password_confirmation", type: "string", minLength: 8)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Register berhasil"),
            new OA\Response(response: 422, description: "Validation Error")
        ]
    )]
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, //default
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    #[OA\Post(
        path: "/api/logout",
        summary: "Logout user",
        tags: ["Auth"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "Logout berhasil"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
    
    #[OA\Get(
        path: "/api/me",
        summary: "Get current user profile",
        tags: ["Auth"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "Berhasil mendapatkan profile"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function me(Request $request)
    {
        $user = $request->user()->load('userOrganizations.organization', 'userOrganizations.division', 'userOrganizations.role');
        
        return response()->json([
            'data' => $user
        ]);
    }
}
