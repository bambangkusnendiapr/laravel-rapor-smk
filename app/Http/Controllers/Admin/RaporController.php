<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rapor\Penilaian;
use App\Models\Rapor;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Ortu;
use App\Models\Wali_kelas;
use App\Models\Master\Lesson;
use App\Models\Master\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\PelajaranGuru;
use RealRashid\SweetAlert\Facades\Alert;

class RaporController extends Controller
{
    public function print($id)
    {
        $rapot = Rapor::find($id);

        if(Auth::user()->hasRole('guru')) {
            
            Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
            return redirect()->route('rapor');
        }

        $user = User::find(Auth::user()->id);

        if(Auth::user()->hasRole('siswa')) {
            $siswa = Student::where('user_id', $user->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $ortu = Ortu::where('user_id', $user->id)->first();
            $siswa = Student::where('ortu_id', $ortu->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        $rapor_data = Rapor::find($id);
        $pelajaran_kelas = Lesson::where('group_id', '!=', 1)->where('kelas', $rapor_data->kelas)->get('id');

        $guru_pelajaran = PelajaranGuru::where('major_id', $rapor_data->student->major_id)->whereIn('lesson_id', $pelajaran_kelas)->get('lesson_id');

        $pelajaran = Lesson::whereIn('id', $guru_pelajaran)->where('group_id', '!=', 1)->where('kelas', $rapor_data->kelas)->get();

        $guru = Teacher::where('user_id', $user->id)->first();
        $wali_kelas = Wali_kelas::where('kelas', $rapor_data->kelas)->where('teacher_id', $guru->id)->first();

        $bulan = null;

        if($rapor_data->tanggal != null) {
            switch($rapor_data->tanggal->format('M')) {
                case 'Dec':
                    $bulan = 'Desember';
                    break;
                case 'Jun':
                    $bulan = 'Juni';
                    break;
                default:
                    $bulan = null;
                    break;
            }
        }

        return view('admin.rapor.print', [
            'nilai' => Penilaian::where('rapor_id', $id)->get(),
            'rapor' => $rapor_data,
            'kelompok' => Group::where('id', '!=', 1)->get(),
            'mapel' => $pelajaran,
            'pelajaran_guru' => PelajaranGuru::where('major_id', $rapor_data->student->major_id)->get(),
            'wali_kelas' => $wali_kelas,
            'bulan' => $bulan,
        ]);
    }
}
