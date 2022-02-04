<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rapor\NilaiPesantren;
use App\Models\Rapor;
use App\Models\User;
use App\Models\Ortu;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Wali_kelas;
use App\Models\Master\Lesson;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RaporPesantrenController extends Controller
{
    public function index($id)
    {
        $rapor = Rapor::find($id);
        $user = User::find(Auth::user()->id);
        if(Auth::user()->hasRole('guru')) {
            
            Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
            return redirect()->route('rapor');
        }

        if(Auth::user()->hasRole('siswa')) {
            
            $siswa = Student::where('user_id', $user->id)->first();

            if($siswa->id != $rapor->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $ortu = Ortu::where('user_id', $user->id)->first();
            $siswa = Student::where('ortu_id', $ortu->id)->first();

            if($siswa->id != $rapor->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        $pelajaran = Lesson::where('group_id', '=', 1)->where('kelas', $rapor->kelas)->get();
        foreach($pelajaran as $data) {
            $lesson[] = $data->id;
        }

        return view('admin.rapor_pesantren.index', [
            'nilai' => NilaiPesantren::where('rapor_id', $id)->whereIn('lesson_id', $lesson)->get(),
            'rapor' => $rapor,
            'mapel' => $pelajaran,
        ]);
    }

    public function print($id)
    {
        $rapor = Rapor::find($id);
        $user = User::find(Auth::user()->id);
        if(Auth::user()->hasRole('guru')) {
            
            Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
            return redirect()->route('rapor');
        }

        if(Auth::user()->hasRole('siswa')) {
            
            $siswa = Student::where('user_id', $user->id)->first();

            if($siswa->id != $rapor->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $ortu = Ortu::where('user_id', $user->id)->first();
            $siswa = Student::where('ortu_id', $ortu->id)->first();

            if($siswa->id != $rapor->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        $pelajaran = Lesson::where('group_id', '=', 1)->where('kelas', $rapor->kelas)->get();
        foreach($pelajaran as $data) {
            $lesson[] = $data->id;
        }

        $guru = Teacher::where('user_id', $user->id)->first();
        $wali_kelas = Wali_kelas::where('kelas', $rapor->kelas)->where('teacher_id', $guru->id)->first();

        return view('admin.rapor_pesantren.print', [
            'nilai' => NilaiPesantren::where('rapor_id', $id)->whereIn('lesson_id', $lesson)->get(),
            'rapor' => $rapor,
            'mapel' => $pelajaran,
            'wali_kelas' => $wali_kelas,
        ]);
    }
}
