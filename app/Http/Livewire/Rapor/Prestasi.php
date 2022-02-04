<?php

namespace App\Http\Livewire\Rapor;

use Livewire\Component;
use App\Models\Rapor\RaporPrestasi;
use App\Models\Rapor;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Student;
use App\Models\Ortu;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class Prestasi extends Component
{
    public $state = [];
    public $idHapus = null;
    public $idEdit = null;
    public $idRapor = null;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $foo;
    public $search = '';
    public $page = 1;

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount($id)
    {
        $this->idRapor = $id;
        $rapot = Rapor::find($this->idRapor);
        $this->search = request()->query('search', $this->search);

        if(Auth::user()->hasRole('guru')) {
            
            Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
            return redirect()->route('rapor');
        }

        if(Auth::user()->hasRole('siswa')) {
            $user = User::find(Auth::user()->id);
            $siswa = Student::where('user_id', $user->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }

        if(Auth::user()->hasRole('orang_tua')) {
            $user = User::find(Auth::user()->id);
            $ortu = Ortu::where('user_id', $user->id)->first();
            $siswa = Student::where('ortu_id', $ortu->id)->first();

            if($siswa->id != $rapot->student_id){
                Alert::warning('Forbidden', 'Anda Tidak Memiliki Akses');
                return redirect()->route('rapor');
            }
        }
    }

    public function render()
    {
        return view('livewire.rapor.prestasi', [
            'prestasi' => RaporPrestasi::where('rapor_id', $this->idRapor)->paginate($this->paginate),
            'rapor' => Rapor::find($this->idRapor),
        ]);
    }

    public function addNew()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {
        Validator::make($this->state, [
            'prestasi' => 'required',
            'ket' => 'required',
        ])->validate();

        $data = new RaporPrestasi;
        $data->rapor_id = $this->idRapor;
        $data->prestasi = $this->state['prestasi'];
        $data->ket = $this->state['ket'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form');
    }

    public function delete($id)
    {
        $this->idHapus = $id;

        $this->dispatchBrowserEvent('show-form-delete');
    }

    public function deleteData()
    {
        $data = RaporPrestasi::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = RaporPrestasi::find($this->idEdit);
        $this->state['prestasi'] = $data->prestasi;
        $this->state['ket'] = $data->ket;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'prestasi' => 'required',
            'ket' => 'required',
        ])->validate();               

        $data = RaporPrestasi::find($this->idEdit);
        $data->prestasi = $this->state['prestasi'];
        $data->ket = $this->state['ket'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
