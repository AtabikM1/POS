<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Http\Controllers\BarangController;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Transaksi Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object)[
            'tittle'=> 'Daftar Penjualan yang tersedia'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $Penjualan = PenjualanModel::with(['user']);

        return DataTables::of($Penjualan)
            ->addIndexColumn()
            ->addColumn('action', function ($Penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/Penjualan/' . $Penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Penjualan/' . $Penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Penjualan/' . $Penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        // Ambil data barang, supplier, user, dan stok
        $user = UserModel::all();
        $supplier = SupplierModel::all();
        $barang = BarangModel::all();
        $stok = StokModel::with('barang')->get(); // Ambil stok dan barang yang terkait
        return view('penjualan.create_ajax', compact('barang', 'user', 'supplier', 'stok'));
    }

   public function store_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20',
            'penjualan_tanggal' => 'required|date|before_or_equal:today',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);

        // Jika validasi gagal, kembalikan response dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        // Validasi berhasil, lanjutkan dengan penyimpanan data
        $validated = $request->all();
        $validated['penjualan_tanggal'] = $validated['penjualan_tanggal'] ?: now(); // Gunakan tanggal saat ini jika kosong

        // Simpan data penjualan
        $penjualan = PenjualanModel::create($validated);

        // Kembalikan response sukses dengan penjualan_id
        return response()->json([
            'status' => true,
            'message' => 'Data penjualan berhasil disimpan',
            'penjualan_id' => $penjualan->penjualan_id // Pastikan penjualan_id ada
        ]);
    }
}

public function create_detail_ajax(Request $request, $penjualan_id)
{
    // Validasi data detail penjualan
    $rules = [
        'barang_id' => 'required|integer',
        'harga' => 'required|numeric',
        'jumlah' => 'required|integer|min:1',
    ];

    $validator = Validator::make($request->all(), $rules);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi Gagal',
            'msgField' => $validator->errors(),
        ]);
    }

    // Simpan detail penjualan
    PenjualanDetailModel::create([
        'penjualan_id' => $penjualan_id,
        'barang_id' => $request->barang_id,
        'harga' => $request->harga,
        'jumlah' => $request->jumlah,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Detail penjualan berhasil disimpan',
    ]);
}

public function storeDetailAjax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        $validated = $validator->validated();

        // Simpan detail penjualan
        PenjualanDetailModel::create($validated);

        // Buat catatan pengurangan stok
        StokModel::create([
            'supplier_id' => null,
            'barang_id' => $validated['barang_id'],
            'user_id' => auth()->id(),
            'stok_tanggal' => now(),
            'stok_jumlah' => -$validated['jumlah'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Detail penjualan dan pengurangan stok berhasil disimpan'
        ]);
    }

    return redirect('/');
}


}
