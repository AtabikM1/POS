<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
        
        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
        ];
        
        $activeMenu = 'kategori';
        
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('action', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . 
                        csrf_field() . 
                        '<input type="hidden" name="_method" value="DELETE">' .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>' .
                        '</form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        
    }
    

}