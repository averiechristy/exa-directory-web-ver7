<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\DetailFile;
use App\Models\User;
use App\Models\UserRead;
use DB;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Log;
use Dompdf\Dompdf;
use Dompdf\Options;

class KontenReadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

        $data = File::find($id);
        $detailFiles = DetailFile::with('File')->where('file_id', $id)->get();

        

        return view ('user.kontenread',[
            'data' => $data,
            'detailFiles' => $detailFiles,
        ]);

    }
 
    public function markFileAsRead(Request $request, $detailfileId)
    {
        // Validasi data yang diterima
        $request->validate([
            '_token' => 'required', // Anda dapat menambahkan validasi lain sesuai kebutuhan
        ]);

        $userid = auth()->id();

        $user = User::find($userid);

        $namauser = $user -> nama_user;



        $detailfile = DetailFile::find($detailfileId);

        $namafile = $detailfile -> file;
        
        // Buat atau update entri UserRead
        $userRead = UserRead::updateOrCreate(
            [
                'detail_file_id' => $detailfileId,
                'user_id' => auth()->id(), // Mengambil ID pengguna yang sedang login
                'nama_file' => $namafile,
                'nama_user' => $namauser
                
            ],
            [
                // Tidak ada data tambahan yang disimpan untuk sekarang, tetapi Anda dapat menambahkannya jika diperlukan
            ]
        );

        // Response jika berhasil
        return response()->json(['success' => true, 'message' => 'File berhasil ditandai sebagai sudah dibaca']);
    }

    public function export(Request $request)
    {
        if (auth()->user()->cabang_id == 1){

        $dataRead = UserRead::all();

        }

        else {
            $Cabang = Auth::user()->cabang_id;

            $dataRead = UserRead::select('user_reads.*')
            ->join('users', 'users.id', '=', 'user_reads.user_id')
            ->where('users.cabang_id', $Cabang)
            ->get();
        }
        
        // Buat HTML untuk tabel data UserRead
        $html = '<html><head><title>Data User Read</title></head><body>';
        $html .= '<h1>Data User Read</h1>';
        $html .= '<table border="1"><thead><tr><th>Nama File</th><th>Nama User</th><th>Tanggal Baca</th></tr></thead><tbody>';
    
        foreach ($dataRead as $data) {
            $html .= '<tr>';
            $html .= '<td>' . $data->nama_file . '</td>';
            $html .= '<td>' . $data->nama_user . '</td>';
            $html .= '<td>' . $data->created_at . '</td>';
            $html .= '</tr>';
        }
    
        $html .= '</tbody></table></body></html>';
    
        // Buat objek Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Tidak perlu menggunakan namespace untuk Options
        $dompdf = new Dompdf($options);
    
        // Konversi HTML menjadi PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Simpan atau kirim file PDF
        $dompdf->stream('data_user_read.pdf');
    }
 public function adminexport(Request $request)
    {
        
            $Cabang = Auth::user()->cabang_id;
            
            $dataRead = UserRead::select('user_reads.*')
            ->join('users', 'users.id', '=', 'user_reads.user_id')
            ->where('users.cabang_id', $Cabang)
            ->get();
    
        
        // Buat HTML untuk tabel data UserRead
        $html = '<html><head><title>Data User Read</title></head><body>';
        $html .= '<h1>Data User Read</h1>';
        $html .= '<table border="1"><thead><tr><th>Nama File</th><th>Nama User</th><th>Tanggal Baca</th></tr></thead><tbody>';
    
        foreach ($dataRead as $data) {
            $html .= '<tr>';
            $html .= '<td>' . $data->nama_file . '</td>';
            $html .= '<td>' . $data->nama_user . '</td>';
            $html .= '<td>' . $data->created_at . '</td>';
            $html .= '</tr>';
        }
    
        $html .= '</tbody></table></body></html>';
    
        // Buat objek Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Tidak perlu menggunakan namespace untuk Options
        $dompdf = new Dompdf($options);
    
        // Konversi HTML menjadi PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Simpan atau kirim file PDF
        $dompdf->stream('data_user_read.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
