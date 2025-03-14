<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
{
    $breadcrumb = (object) [
        'title' => 'Daftar Barang',
        'list' => ['Home', 'Barang']
    ];
    
    $page = (object) [
        'title' => 'Daftar barang yang terdaftar dalam sistem',
    ];
    
    $activeMenu = 'barang';
    $kategori = KategoriModel::all(); // Tambahkan ini

    return view('barang.index', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'kategori' => $kategori // Kirim ke view
    ]);
}

    
     public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->with('kategori');
        
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $barang->where('kategori_id', $request->kategori_id);
        }
        
        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('action', function ($barang) {
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">' . 
                        csrf_field() . 
                        '<input type="hidden" name="_method" value="DELETE">' .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>' .
                        '</form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        
        $page = (object) [
            'title' => 'Tambah barang baru',
        ];
        
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';
        
        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);
        
        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        
        return redirect('/barang')->with('success', 'Barang berhasil ditambahkan');
    }
    
    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        
        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail'],
        ];
        
        $page = (object) [
            'title' => 'Detail barang',
        ];
        
        $activeMenu = 'barang';
        
        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();
        
        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];
        
        $page = (object) [
            'title' => 'Edit barang',
        ];
        
        $activeMenu = 'barang';
        
        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);
        
        BarangModel::find($id)->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        
        return redirect('/barang')->with('success', 'Barang berhasil diupdate');
    }
    
    public function destroy(string $id)
    {
        BarangModel::find($id)->delete();
        
        return redirect('/barang')->with('success', 'Barang berhasil dihapus');
    }
}