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
}
