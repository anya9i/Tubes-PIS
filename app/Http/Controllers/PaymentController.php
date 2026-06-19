<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pesanan;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Ambil Server Key dari config (Pastikan sudah diisi di .env)
        $serverKey = config('services.midtrans.server_key');

        // 2. Buat Hash Signature untuk validasi keamanan
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // LOG: Mengetahui ada data masuk
        Log::info("=== Callback Midtrans Masuk ===");
        Log::info("Order ID: " . $request->order_id);

        // 3. Validasi Signature
        if ($hashed == $request->signature_key) {
            Log::info("Signature Valid!");

            // 4. Ambil ID Transaksi (Potong timestamp di belakang)
            // Contoh: BSR-2026-001-1778659867 menjadi BSR-2026-001
            $orderIdFromMidtrans = $request->order_id;
            $lastDashPos = strrpos($orderIdFromMidtrans, '-');
            $cleanOrderId = substr($orderIdFromMidtrans, 0, $lastDashPos);

            Log::info("Mencari di database id_transaksi: " . $cleanOrderId);

            // 5. Cari data di tabel Pesanan menggunakan kolom 'id_transaksi'
            $pesanan = Pesanan::where('id_transaksi', $cleanOrderId)->first();

            if ($pesanan) {
                Log::info("Data Pesanan Ditemukan. Status saat ini: " . $pesanan->payment_status);

                // 6. Cek Status Transaksi
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    
                    // Update ke LUNAS
                    $pesanan->update(['payment_status' => 'LUNAS']);
                    Log::info("Berhasil! Status Pesanan $cleanOrderId diupdate menjadi LUNAS.");

                } elseif (in_array($request->transaction_status, ['deny', 'expire', 'cancel'])) {
                    
                    // Update ke BATAL
                    $pesanan->update(['payment_status' => 'BATAL']);
                    Log::warning("Pesanan $cleanOrderId otomatis BATAL.");
                }

            } else {
                Log::error("Gagal! Pesanan dengan ID $cleanOrderId tidak ditemukan di database.");
            }
        } else {
            Log::error("Signature TIDAK VALID. Periksa Server Key Midtrans kamu.");
        }

        return response()->json(['message' => 'Callback processed']);
    }
}