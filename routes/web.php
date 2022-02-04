<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {

    //Profile
    Route::get('profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');  
    Route::post('profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');  
    Route::post('profile-password', [App\Http\Controllers\Admin\ProfileController::class, 'update_password'])->name('profile.update.password');  

    //Dashboard
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');  

    Route::group(['middleware' => ['role:superadmin|wali_kelas']], function() {
        
        //Master Data
        Route::get('/pelajaran', \App\Http\Livewire\Master\Pelajaran::class)->name('pelajaran');
        Route::get('/semester', \App\Http\Livewire\Master\SemesterData::class)->name('semester');
        Route::get('/jurusan', \App\Http\Livewire\Master\Jurusan::class)->name('jurusan');
        Route::get('/kelompok', \App\Http\Livewire\Master\KelompokPelajaran::class)->name('kelompok');
        Route::get('/ekstrakurikuler', \App\Http\Livewire\Master\Ekstrakurikuler::class)->name('ekstrakurikuler');
        Route::get('/jabatan', \App\Http\Livewire\Master\Jabatan::class)->name('jabatan');
    
        Route::resources([
            'students' => App\Http\Controllers\Admin\StudentController::class,
        ]);
        Route::get('download', [App\Http\Controllers\Admin\StudentController::class, 'download'])->name('download');
        Route::post('import', [App\Http\Controllers\Admin\StudentController::class, 'import'])->name('import');
    
        //Wali Kelas
        Route::get('/wali-kelas', \App\Http\Livewire\WaliKelas::class)->name('wali.kelas');
        
    //Guru
        Route::get('/guru', \App\Http\Livewire\Guru::class)->name('guru');
        Route::get('/pelajaran-guru', \App\Http\Livewire\PelajaranGuruData::class)->name('pelajaran.guru');
        Route::post('import-guru', [App\Http\Controllers\Admin\TeacherController::class, 'import'])->name('import.guru');
    
        //Orang Tua
        Route::get('/orang-tua', \App\Http\Livewire\OrangTua::class)->name('ortu');
    
    });



    //Penilaian Rapor
    Route::get('/rapor', \App\Http\Livewire\RaporData::class)->name('rapor');
    Route::get('/rapor/eskul/{id}', \App\Http\Livewire\Rapor\Eskul::class)->name('eskul');
    Route::get('/rapor/prestasi/{id}', \App\Http\Livewire\Rapor\Prestasi::class)->name('prestasi');
    Route::get('/rapor/eskul/pesantren/{id}', \App\Http\Livewire\Rapor\EskulPesantren::class)->name('eskul.pesantren');

    Route::group(['middleware' => ['role:superadmin|wali_kelas|guru']], function() {

        Route::get('/rapor/penilaian/{id}', \App\Http\Livewire\Rapor\PenilaianData::class)->name('penilaian');
        Route::get('/rapor/penilaian-pesantren/{id}', \App\Http\Livewire\Rapor\PenilaianPesantren::class)->name('penilaian.pesantren');
        Route::get('/rapor/nilai', [App\Http\Controllers\Admin\NilaiController::class, 'index'])->name('rapor.nilai');
        Route::post('/rapor/nilai', [App\Http\Controllers\Admin\NilaiController::class, 'pilih'])->name('rapor.pilih');
        Route::get('/rapor/nilai-input', [App\Http\Controllers\Admin\NilaiController::class, 'input'])->name('input.nilai');

    });

    //Rapor Umum
    Route::get('/rapor/penilaian-rapor/{id}', \App\Http\Livewire\Rapor\PenilaianRapor::class)->name('penilaian.rapor');
    Route::get('/rapor/print/{id}', [App\Http\Controllers\Admin\RaporController::class, 'print'])->name('rapor.print');

    //Rapor Pesantren
    Route::get('/rapor/rapor-pesantren/{id}', [App\Http\Controllers\Admin\RaporPesantrenController::class, 'index'])->name('rapor.pesantren');
    Route::get('/rapor/rapor-pesantren/print/{id}', [App\Http\Controllers\Admin\RaporPesantrenController::class, 'print'])->name('rapor.pesantren.print');

    Route::group(['middleware' => ['role:superadmin']], function() {
        Route::get('/bayar', \App\Http\Livewire\Bayar::class)->name('bayar');
    });
  
});
