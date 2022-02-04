<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{  asset('vendor/css/reset.css') }}">
    <link rel="stylesheet" href="{{  asset('vendor/css/style.css') }}">
    <title>Rapor Kepesantrenan</title>
    <style>
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }
        
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        
        @media print {
            body {
                width: 35cm;
                height: 29.0cm;
                margin: 30mm 45mm 30mm -27mm;
            }
        }
    </style>
</head>

<body>

    <div class="container my-3">
        <h5 class="d-flex justify-content-center">LAPORAN HASIL BELAJAR SISWA</h5>
        <h6 class="d-flex justify-content-center">SEMESTER {{ strtoupper($rapor->semester->nama) }} KEPESANTRENAN</h6>
        <h6 class="d-flex justify-content-center">TAHUN PELAJARAN {{ $rapor->semester->tahun }}</h6>
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <table>
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>&nbsp;&nbsp;&nbsp;:</td>
                            <td>{{ $rapor->student->user->name }}</td>
                        </tr>
                        <tr>
                            <td>NIS</td>
                            <td>&nbsp;&nbsp;&nbsp;:</td>
                            <td>{{ $rapor->student->nis }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <table>
                    <tbody>
                        <tr>
                            <td>Kelas</td>
                            <td>&nbsp;&nbsp;&nbsp;:</td>
                            <td>{{ $rapor->kelas }} {{ $rapor->student->major->jurusan }}</td>
                        </tr>
                        <tr>
                            <td>Komp. Keahlian</td>
                            <td>&nbsp;&nbsp;&nbsp;:</td>
                            <td>{{ $rapor->student->major->ket }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
    </div>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="2">no</th>
                        <th rowspan="2">Komponen</th>
                        <th rowspan="2">KKM</th>
                        <th colspan="3">Nilai</th>
                        <th rowspan="2">Ketuntasan</th>
                    </tr>
                    <tr>
                        <th>Angka</th>
                        <th>Huruf</th>
                        <th>Pred</th>
                    </tr>
                    <tr>
                        <th colspan="7">A. Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($mapel as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                          {{ $data->nama }}
                        </td>
                        @forelse($nilai->where('lesson_id', $data->id) as $value)
                        <td>{{ $value->kkm }}</td>
                        <td>{{ $value->nilai }}</td>
                        <td>{{ $value->huruf }}</td>
                        <td>{{ $value->predikat }}</td>
                        <td>{{ $value->tuntas }}</td>
                        @empty
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        @endforelse
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">Jumlah</th>
                        <td></td>
                        <th>{{ $nilai->sum('nilai') }}</th>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th colspan="2">Peringkat Ke-</th>
                        <td>&nbsp;</td>
                        <td colspan="5">dari siswa</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- catatan wali kelas -->
        <div class="catatan">
            <p>{{ $rapor->catatan_pesantren }}</p>
        </div>
    </div>



    <!-- ekstrakulikuler -->
    <div class="container mt-3 mb-3">
        <h5 class="text-center">CATATAN AKHIR SEMESTER</h5>
        <h6>1. Pengembangan Diri dan Kepribadian</h6>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th colspan="2">Komponen</th>
                    <th>Predikat</th>
                </tr>
                <tr>
                    <th rowspan="3" class="text-center" style="line-height: 120px;">Kepribadian</th>
                    <th colspan="1">1. Kelakukan</th>
                    <th colspan="1">{{ $rapor->kelakuan }}</th>
                </tr>
                <tr>
                    <th colspan="1">1. Kedisiplinan</th>
                    <th colspan="1">{{ $rapor->disiplin }}</th>
                </tr>
                <tr>
                    <th colspan="1">3. Kerapihan</th>
                    <th colspan="1">{{ $rapor->rapih }}</th>
                </tr>
            </thead>
        </table>
        <h6>2. Ekstrakurikuler</h6>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Ekstrakurikuler / Pengembangan Diri</th>
                    <th>Predikat</th>
                </tr>
                @foreach($rapor->pesantreneskul as $extra)
                <tr>
                    <th colspan="1">{{ $extra->extracurricular->nama }}</th>
                    <th colspan="1">{{ $extra->predikat }}</th>
                </tr>
                @endforeach
            </thead>
        </table>
        <h6>3. Ketidakhadiran</h6>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th rowspan="4" class="text-center" style="line-height: 120px;">Ketidakhadiran</th>
                </tr>
                <tr>
                    <th>Sakit</th>
                    <th>{{ $rapor->sakit_pesantren }} Hari</th>
                </tr>
                <tr>
                    <th>Izin</th>
                    <th>{{ $rapor->izin_pesantren }} Hari</th>
                </tr>
                <tr>
                    <th>Tanpa Keterangan</th>
                    <th>{{ $rapor->alpa_pesantren }} Hari</th>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th colspan="2"></th>
                </tr>
                @if(strtoupper($rapor->semester->nama) == "GENAP")
                <tr>
                    <th>Naik / <del>Tidak naik</del></th>
                    <th colspan="2">Ke Kelas XII</th>
                </tr>
                @endif
            </thead>
        </table>
    </div>



    <!-- ttd -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <div class="orangtua">
                <h6>Orang Tua/Wali</h6>
                <br><br><br><br>
                <b><p>{{ $rapor->student->ortu->user->name }}</p></b>
            </div>
            <div class="kepsek mt-5" style="margin-top: 10rem!important;">
                <div class="text-center">
                    <h6>Mengetahui</h6>
                    <h6>Kepala Sekolah,</h6>
                </div>
                <br><br><br><br>
                <b><p>H. Jejen Jaenudin, M.Pd.I</p></b>
            </div>
            <div class="walikelas">
                <div class="text-center">
                    <h6>Bandung, 16 Desember 2020</h6>
                    <h6>Wali Kelas</h6>
                </div>
                <br><br><br>
                <b><p>{{ $wali_kelas->teacher->user->name }}</p></b>
            </div>
        </div>
    </div>
</body>

</html>