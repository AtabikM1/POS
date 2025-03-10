<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class LevelController extends Controller
{
    // public function index(){
    //     // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?,?,?)', ['CUS', 'Pelanggan', now()]);
    //     // return 'Insert data baru berhasil';
    //     // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
    //     // return 'Update data berhasil. jumlah data yang diupdate: '.$row. ' baris';
    //     // $row = DB::delete('delete from m_level where level_kode = ?', ['cus']);
    //     // return 'Delete data berhasil, jumlah data yang dihapus: '. $row. ' baris';
    //     // $data = DB::select('select * from m_level');
    //     // return view('level', ['data' => $data]);
    //     $breadcrumb = (object)[
    //         'title' => 'Daftar Level', 
    //         'list'
    //     ]
        
    // }
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Level', 
            'list' => ['Home', 'Level']
        ];
        $page = (object)[
            'title' => "Daftar level yang terdaftar dalam sistem"
        ];

        $activeMenu =  'level';
        $levels = Level::all();
        // dd($activeMenu);
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'levels' => $levels, 'activeMenu' => $activeMenu]);


    }
    public function list(Request $request)
    {
    // Query model Level dengan select kolom yang diperlukan
    $levels = Level::select('level_id', 'level_kode', 'level_nama');

    // Filter berdasarkan level_id jika ada input filter
    if ($request->has('level_id') && !empty($request->level_id)) {
        $levels->where('id', $request->level_id);
    }

    return DataTables::of($levels)
        ->addIndexColumn() // Menambahkan kolom index (DT_RowIndex)
        ->addColumn('aksi', function ($level) { // Menambahkan kolom aksi
            $btn = '<a href="' . url('/level/' . $level->id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/level/' . $level->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->id) . '">';
            $btn .= csrf_field();
            $btn .= method_field('DELETE');
            $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button>';
            $btn .= '</form>';
            return $btn;
        })
        ->rawColumns(['aksi']) // Memberitahu DataTables bahwa kolom aksi mengandung HTML
        ->make(true);
}


}
