<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

class TransactionAnnotations
{
    /**
     * @OA\Get(
     *     path="/organizations/{organization}/transactions",
     *     tags={"Transactions"},
     *     summary="Mengambil daftar transaksi suatu organisasi",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         description="ID dari Organisasi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="page", in="query", description="Nomor halaman untuk Paginasi", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="status", in="query", description="Filter by status (pending, approved, rejected)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="month", in="query", description="Filter by month (1-12)", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="year", in="query", description="Filter by year (ex: 2026)", @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Post(
     *     path="/organizations/{organization}/transactions",
     *     tags={"Transactions"},
     *     summary="Membuat transaksi pengeluaran / pemasukan baru",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         description="ID dari Organisasi",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category_id", "amount", "transaction_date"},
     *             @OA\Property(property="division_id", type="integer", description="Opsional. Id divisi penanggung jawab"),
     *             @OA\Property(property="category_id", type="integer", description="ID Kategori pemasukan/pengeluaran"),
     *             @OA\Property(property="amount", type="number", format="float", example=150000.50),
     *             @OA\Property(property="description", type="string", example="Pembelian ATK Kantor"),
     *             @OA\Property(property="transaction_date", type="string", format="date", example="2026-05-12")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Transaksi Dibuat")
     * )
     */
    public function store() {}

    /**
     * @OA\Patch(
     *     path="/transactions/{transaction}/status",
     *     tags={"Transactions"},
     *     summary="Update status persetujuan transaksi (Admin/Manager Hanya)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="transaction",
     *         in="path",
     *         description="ID dari Transaksii",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="string", enum={"pending", "approved", "rejected"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Status berhasil diubah"),
     *     @OA\Response(response=403, description="Tidak punya akses Otorisasi")
     * )
     */
    public function changeStatus() {}
}
