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
use Illuminate\Support\Facades\DB;

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
    $user = UserModel::all();
    $supplier = SupplierModel::all();
    $barang = BarangModel::all();
    $stok = StokModel::with('barang')->get();

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
            // 'detail_penjualan' => 'required|array|min:1',
            'detail.*.barang_id' => 'required|integer',
            'detail.*.harga' => 'required|numeric',
            'detail.*.jumlah' => 'required|integer|min:1',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            // Simpan penjualan
            $penjualanData = $request->only(['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal']);
            $penjualan = PenjualanModel::create($penjualanData);

            // Simpan detail penjualan
            foreach ($request->detail as $detail)
{
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $detail['barang_id'],
                    'harga' => $detail['harga'],
                    'jumlah' => $detail['jumlah'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan & detail berhasil disimpan',
                'penjualan_id' => $penjualan->penjualan_id,
                'penjualan' => $penjualan,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
public function show_ajax(string $id)
    {
        $penjualan = penjualandetailModel::with('kategori')->find($id);
        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }



}
