<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Stok Barang',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok barang yang tersedia',
        ];

        $activeMenu = 'stok';

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'supplier', 'user']);

        if ($request->has('barang_id') && !empty($request->barang_id)) {
            $stok->where('barang_id', $request->barang_id);
        }

        if ($request->has('supplier_id') && !empty($request->supplier_id)) {
            $stok->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('action', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // public function show_ajax($id)
    // {
    //     $stok = StokModel::with(['barang', 'supplier', 'user'])->find($id);
    //     return view('stok.show_ajax', ['stok' => $stok]);
    // }

    public function create_ajax(){
        $user = UserModel::all();
        $supplier = SupplierModel::all();
        $barang = BarangModel::all();
        return view('stok.create_ajax', ['barang' => $barang, 'user' => $user, 'supplier' => $supplier]);
    }

    public function store_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()){
            $rules = [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date|before_or_equal:today',
                'stok_jumlah' => 'required|integer',
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'status'=> false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $stok = StokModel::create($request->all());
            return response()->json([
                'status' =>true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
        return redirect('/');
    }


}