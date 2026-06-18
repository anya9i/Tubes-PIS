<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Reseller;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $pesanans = $query->latest()->paginate(10);
        return view('pesanan.index', compact('pesanans'));
    }

    public function show($id)
{
    // 1. AMBIL DATA DULU (Pindahkan ke paling atas fungsi)
    $pesanan = Pesanan::with('user')->findOrFail($id);

    // 2. KONFIGURASI MIDTRANS
    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // 3. SUSUN PARAMETER (Sekarang $pesanan sudah ada isinya)
    $params = [
        'transaction_details' => [
            'order_id' => 'BRS-' . $pesanan->id . '-' . time(),
            'gross_amount' => (int) $pesanan->total_harga,
        ],
        'customer_details' => [
            'first_name' => $pesanan->nama_pelanggan ?? ($pesanan->user->nama_reseller ?? 'Pelanggan'),
            'phone' => $pesanan->no_hp ?? '08123456789',
        ],
    ];

    // 4. MINTA TOKEN
    try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            $snapToken = null; // Agar tidak langsung error 500 jika koneksi internet/key bermasalah
        }

        return view('pesanan.show', compact('pesanan', 'snapToken'));
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $resellers = Reseller::all(); 
        return view('pesanan.edit', compact('pesanan', 'resellers'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'user_id'    => 'required',
            'total_produk'   => 'required|numeric',
            'status'         => 'required',
            'payment_status' => 'required',
            'payment_url'    => 'nullable|url',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // 2. Update Database (Pindah ke ATAS return)
        $pesanan->update([
            'user_id'        => $request->user_id,
            'nama_pelanggan' => $request->nama_pelanggan, // Tambahkan ini agar nama manual bisa diedit
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'total_produk'   => $request->total_produk,
            'status'         => $request->status,
            'payment_status' => $request->payment_status,
            'payment_url'    => $request->payment_url,
        ]);

        // 3. Pintu keluar (Redirect) taruh di PALING BAWAH
        return redirect()->route('pesanan.index')->with('success', 'Data pesanan berhasil diperbarui!');
    }

    public function pay($id)
{
    $pesanan = Pesanan::with('user')->findOrFail($id);

    // Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $pesanan->id_transaksi . '-' . time(),
            'gross_amount' => (int) $pesanan->total_harga,
        ],
        'customer_details' => [
            'first_name' => $pesanan->user->nama_lengkap,
            'email' => $pesanan->user->email,
            'phone' => $pesanan->no_telepon_pengiriman,
        ],
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    return view('pesanan.pay', compact('pesanan', 'snapToken'));
}


public function cancelConfirm($id)
{
    $pesanan = Pesanan::findOrFail($id);
    return view('pesanan.cancel', compact('pesanan'));
}


public function callback(Request $request)
{
    $serverKey = env('MIDTRANS_SERVER_KEY');
    $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    // Tambahkan LOG ini untuk debugging
    \Log::info('Callback Midtrans Masuk: ' . $request->order_id . ' Status: ' . $request->transaction_status);

    if ($hashed == $request->signature_key) {
        $orderIdParts = explode('-', $request->order_id);
        // Pastikan jumlah '-' sesuai dengan format BSR-2026-001
        $originalOrderId = $orderIdParts[0] . '-' . $orderIdParts[1] . '-' . $orderIdParts[2];

        $pesanan = Pesanan::where('id_transaksi', $originalOrderId)->first();

        if (!$pesanan) {
            \Log::error('Pesanan tidak ditemukan: ' . $originalOrderId);
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            // PASTIKAN 'payment_status' ini sesuai nama kolom di database kamu!
            $pesanan->update(['payment_status' => 'LUNAS']); 
            \Log::info('Pesanan ' . $originalOrderId . ' BERHASIL DIUPDATE JADI LUNAS');
        }
        // ... (sisanya sama)
        return response()->json(['message' => 'Berhasil']);
    }

    \Log::warning('Signature Key Salah!');
    return response()->json(['message' => 'Signature Key Salah'], 403);
}

}