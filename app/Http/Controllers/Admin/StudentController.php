<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Ortu;
use App\Models\Master\Major;
use RealRashid\SweetAlert\Facades\Alert;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.student.index', [
            'students' => Student::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.student.create', [
            'ortu' => Ortu::all(),
            'jurusan' => Major::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nis' => 'required',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->attachRole('siswa');

        $student = new Student;
        $student->user_id = $user->id;
        $student->kelas = $request->kelas;
        $student->major_id = $request->jurusan;
        $student->ortu_id = $request->ortu;
        $student->nis = $request->nis;
        $student->no_induk = $request->noInduk;
        $student->tempat_lahir = $request->tempatLahir;
        $student->tgl_lahir = $request->tgl_lahir;
        $student->jk = $request->jk;
        $student->agama = $request->agama;
        $student->warganegara = $request->warganegara;
        $student->hp = $request->hp;
        $student->alamat = $request->alamat;
        $student->save();

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
        return redirect()->route('students.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('students.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.student.edit', [
            'student' => Student::find($id),
            'ortu' => Ortu::all(),
            'jurusan' => Major::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $user = User::find($student->user_id);

        if($request->email !=  $user->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        if($request->password) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user->password = bcrypt($request->password);
        }

        $user->name = $request->nama;
        $user->email = $request->email;
        $user->save();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nis' => 'required',
        ]);

        $student->kelas = $request->kelas;
        $student->major_id = $request->jurusan;
        $student->nis = $request->nis;
        $student->no_induk = $request->noInduk;
        $student->tempat_lahir = $request->tempatLahir;
        $student->tgl_lahir = $request->tgl_lahir;
        $student->jk = $request->jk;
        $student->agama = $request->agama;
        $student->warganegara = $request->warganegara;
        $student->hp = $request->hp;
        $student->alamat = $request->alamat;
        $student->save();

        Alert::success('Berhasil', 'Data Berhasil Diedit');
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->detachRole('siswa');
        $user->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus');
        return redirect()->route('students.index');
    }

    public function download()
    {
        return response()->download(public_path('file/siswa.xlsx'));
    }

    public function import(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        Alert::success('Sukses', 'Data Berhasil Diupload');
        return redirect()->back();
    }
}
