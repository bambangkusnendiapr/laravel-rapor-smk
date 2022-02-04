<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('vendor/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">
    <title>Rapor UMUM</title>
    <style>
        body {
            width: 100%;
            height: 100%;
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
                width: 40cm;
                height: 29.7cm;
                margin: 30mm 45mm 30mm -52mm;
            }
        }
    </style>
</head>

<body>

    <div class="page">


        <div class="container my-3">
            <h5 class="d-flex justify-content-center mb-4">PENCAPAIAN KOMPETENSI PESERTA DIDIK</h5>
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <table>
                        <tbody>
                            <tr>
                                <td>Nama Sekolah</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>SMK PERSIS 02 KOTA BANDUNG</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>Jl Sukamulya dalam I RT.06 Rw.09 Kel. Sukaasih Kec. Bojongloa Kaler</td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->student->user->name }}</td>
                            </tr>
                            <tr>
                                <td>No Induk</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->student->no_induk }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex">
                    <table>
                        <tbody>
                            <tr>
                                <td>NISN</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->student->nis }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->kelas }}/{{ $rapor->student->major->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Semester</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->semester->nama }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Pelajaran</td>
                                <td>&nbsp;&nbsp;&nbsp;:</td>
                                <td>{{ $rapor->semester->tahun }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
        </div>

        <!-- sikap -->
        <div class="container mb-2">
            <h5>A. Sikap</h5>
            <div class="flex flex-column">
                <div class="sikap mb-2">
                    <h6>&nbsp;&nbsp;1. Sikap Spiritual</h6>
                    <div class="border">
                        <p>Deskripsi:</p>
                        <p>{{ $rapor->spiritual }}</p>
                    </div>
                </div>
                <div class="sosial">
                    <h6>&nbsp;&nbsp;2. Sikap Sosial</h6>
                    <div class="border">
                        <p>Deskripsi:</p>
                        <p>{{ $rapor->sosial }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- pengetahuan dan keterampilan -->
        <div class="container">
            <h5>B. Pengetahuan dan Keterampilan</h5>
            <h6>&nbsp;&nbsp;Ketuntasan Belajar Minimal : 75</h6>
            <div class="">
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Mata Pelajaran</th>

                            <th colspan="3">Pengetahuan</th>
                            <th colspan="3">Keterampilan</th>
                        </tr>
                        <tr>
                            <th>nilai</th>
                            <th>predikat</th>
                            <th>deskripsi</th>

                            <th>nilai</th>
                            <th>predikat</th>
                            <th>deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($kelompok as $k)
                        <tr>
                            <th colspan="8">{{ $k->nama }}</th>
                        </tr>
                        @foreach($mapel->where('group_id', $k->id) as $m)
                        @php $i++; @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                {{ $m->nama }}<br>
                                @foreach($pelajaran_guru->where('lesson_id', $m->id) as $pg)
                                <span class="badge bg-primary">{{ $pg->teacher->user->name }}</span>
                                @endforeach
                            </td>
                            @forelse($nilai->where('lesson_id', $m->id) as $value)
                            <td>{{ $value->pengetahuan_nilai }}</td>
                            <td>{{ $value->pengetahuan_predikat }}</td>
                            <td>{{ $value->pengetahuan_deskripsi }}</td>
                            <td>{{ $value->keterampilan_nilai }}</td>
                            <td>{{ $value->keterampilan_predikat }}</td>
                            <td>{{ $value->keterampilan_deskripsi }}</td>
                            @empty
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            @endforelse
                        </tr>
                        @endforeach
                        @endforeach
                        <tr>
                            <th colspan="2">Jumlah</th>
                            <th>{{ $nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')}}</th>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <th colspan="2">Rata-rata</th>
                            <th>@if(($nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')) != 0)
                                {{ number_format((float)($nilai->sum('pengetahuan_nilai') +  $nilai->sum('keterampilan_nilai')) / ($nilai->count() * 2), 2, ',', '')}}
                                @endif</th>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <th colspan="2">Peringkat ke</th>
                            <td colspan="6"><b></b> dari Siswa</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ekstrakulikuler -->
        <div class="container">
            <h5>C. Ekstra Kurikuler</h5>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Kegiatan Ekstra Kurikuler</th>
                        <th>Nilai</th>
                        <th>Keterangan dalam kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapor->raporeskul as $eskul)
                    <tr>
                        <td>{{ $eskul->extracurricular->nama }}</td>
                        <td>{{ $eskul->nilai }}</td>
                        <td>{{ $eskul->ket }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ketidakhadiran -->
        <div class="container">
            <h5>D. Ketidakhadiran</h5>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">Ketidakhadiran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="2">1</td>
                        <td>Sakit</td>
                        <td>{{ $rapor->sakit }} Hari</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Izin</td>
                        <td>{{ $rapor->izin }} Hari</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tanpa Keterangan</td>
                        <td>{{ $rapor->alpa }} Hari</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- prestasi -->
        <div class="container">
            <h5>E. Prestasi</h5>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Jenis Prestasi</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapor->raporprestasi as $prestasi)
                    <tr>
                        <td width="2">{{ $loop->iteration }}</td>
                        <td>{{ $prestasi->prestasi }}</td>
                        <td>{{ $prestasi->ket }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- catatan wali kelas -->
        <div class="container mb-2">
            <h5>F. Catatan Wali Kelas</h5>
            <div class="catatan">
                <p>{{ $rapor->catatan }}</p>
            </div>
        </div>

        <!-- orangtua -->
        <div class="container mb-4">
            <h5>G. Tanggapan Orang tua/wali</h5>
            <div class="catatan">
                <p>{{ $rapor->catatan_ortu }}</p>
            </div>
        </div>

        <!-- ttd -->
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="orangtua">
                    <h6>Orang Tua/Wali</h6>
                    <br><br><br><br><br>
                    <p>{{ $rapor->student->ortu->user->name }}</p>
                </div>
                <div class="walikelas">
                    <h6>Wali Kelas</h6>
                    <br><br><br><br><br>
                    <b><p>{{ $wali_kelas->teacher->user->name }}</p></b>
                </div>
                <div class="kepsek">
                    <h6>Bandung, @if($rapor->tanggal != null) {{ $rapor->tanggal->format('d') }} {{ $bulan }} {{ $rapor->tanggal->format('Y') }} @endif</h6>
                    <h6>Mengetahui</h6>
                    <h6>Kepala Sekolah,</h6>
                    <br><br><br><br>
                    <b><p>H. Jejen Jaenudin, M.Pd.I</p></b>
                </div>
            </div>
        </div>
    </div>
</body>

</html>