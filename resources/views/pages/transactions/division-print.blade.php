@php

use Illuminate\Support\Str;
use Carbon\Carbon;

@endphp

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Transaksi Divisi
    </title>

    <style>

        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 30px;
            color: #6B7280;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #D1D5DB;
            padding: 8px;
        }

        th {
            background: #F3F4F6;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 25px;
            width: 320px;
            margin-left: auto;
        }

        .summary table {
            margin-top: 0;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

    </style>

</head>

<body>

    <h1>
    LAPORAN TRANSAKSI DIVISI
    </h1>

    <div class="subtitle">
        OrgAudit
    </div>

    <div class="info">

        <p>
            <strong>Nama Organisasi :</strong>
            {{ $organization->name }}
        </p>

        <p>
            <strong>Nama Divisi :</strong>
            {{ $division->name }}
        </p>

        <p>
            <strong>Dicetak Oleh :</strong>
            {{ $printedBy->name }}
        </p>

        <p>
            <strong>Tanggal Cetak :</strong>
            {{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
        </p>

        <p>
            <strong>Periode :</strong>
            {{ $startDate
                ? Carbon::parse($startDate)->translatedFormat('d F Y')
                : 'Awal'
            }}

            -

            {{ $endDate
                ? Carbon::parse($endDate)->translatedFormat('d F Y')
                : 'Sekarang'
            }}
        </p>

    </div>

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Kategori</th>

                <th>Deskripsi</th>

                <th>Nominal</th>

                <th>Status</th>

                <th>Dibuat Oleh</th>

            </tr>

        </thead>

        <tbody>

            @forelse($transactions as $transaction)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ ucfirst($transaction->category) }}
                    </td>

                    <td>
                        {{ Str::limit(
                            $transaction->description,
                            40,
                            '...'
                        ) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ ucfirst($transaction->status) }}
                    </td>

                    <td>
                        {{ $transaction->createdBy?->name }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" align="center">
                        Tidak ada data transaksi
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="summary">

        <table>

            <tr>

                <td>
                    Total Pemasukan
                </td>

                <td class="text-right">

                    Rp {{ number_format($totalIncome, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <td>
                    Total Pengeluaran
                </td>

                <td class="text-right">

                    Rp {{ number_format($totalExpense, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <th>
                    Saldo
                </th>

                <th class="text-right">

                    Rp {{ number_format($balance, 0, ',', '.') }}

                </th>

            </tr>

        </table>

    </div>

    <div class="footer">

        <p>

            Dicetak oleh,

            <br><br><br><br>

            <strong>
                {{ $printedBy->name }}
            </strong>

        </p>

    </div>

    <script>

        window.onload = function () {

            window.print();

        }

    </script>

</body>

</html>