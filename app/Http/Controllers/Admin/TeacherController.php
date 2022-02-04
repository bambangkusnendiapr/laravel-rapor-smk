<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Imports\TeacherImport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function import(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new TeacherImport, $request->file('file'));

        Alert::success('Sukses', 'Data Berhasil Diupload');
        return redirect()->back();
    }
}
