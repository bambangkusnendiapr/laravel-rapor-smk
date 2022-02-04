<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Master\Lesson;
use App\Models\Master\Semester;
use App\Models\Master\Major;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Rapor;
use App\Models\PelajaranGuru;

class NilaiController extends Controller
{
    private $pelajaran = null;
    private $pilih_pelajaran = null;
    private $siswa = null;
    private $rapor = null;

    public function index() {
        // $user = User::find(Auth::user()->id);
        if(Auth::user()->hasRole('wali_kelas') || Auth::user()->hasRole('guru')) {
            $guru = Teacher::where('user_id', Auth::user()->id)->first();
            $pelajaran_guru = PelajaranGuru::where('teacher_id', $guru->id)->get('lesson_id');
            $this->pelajaran = Lesson::whereIn('id', $pelajaran_guru)->get();
        }

        return view('admin.nilai.index', [
            'pelajaran' => $this->pelajaran,
            'semester' => Semester::all(),
            'jurusan' => Major::all(),
        ]);
    }

    public function pilih(Request $request) {
        // dd($request->all());
        $this->pilih_pelajaran = Lesson::find($request->pelajaran);
        $this->siswa = Student::where('kelas', $this->pilih_pelajaran->kelas)->where('major_id', $request->jurusan)->get('id');
        $this->rapor = Rapor::where('kelas', $this->pilih_pelajaran->kelas)->where('semester_id', $request->semester)->whereIn('student_id', $this->siswa)->get();
        return redirect()->route('input.nilai');
    }

    public function input() {
        dd($this->pilih_pelajaran);
        return view('admin.nilai.nilai', [
            'pelajaran' => $this->pilih_pelajaran,
        ]);
    }
}
