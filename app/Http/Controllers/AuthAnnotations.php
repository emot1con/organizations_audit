<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

class AuthAnnotations
{
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Login ke sistem dan dapatkan Sanctum API Token",
     *     description="Digunakan untuk mengautentikasi pengguna dan mengembalikan token otorisasi.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login sukses"),
     *             @OA\Property(property="token", type="string", example="1|xxxxxxxxxxxxxxxxxxxxxxxx")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Kredensial tidak valid")
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Authentication"},
     *     summary="Daftar akun baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="User Baru"),
     *             @OA\Property(property="email", type="string", format="email", example="new@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Registrasi Berhasil"),
     *     @OA\Response(response=422, description="Validasi Gagal")
     * )
     */
    public function register() {}
}
