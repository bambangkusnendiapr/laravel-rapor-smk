<?php

namespace App\Http\Livewire\Rapor;

use Livewire\Component;
use App\Models\Rapor\PesantrenEskul;
use App\Models\Rapor;
use App\Models\User;
use App\Models\Student;
use App\Models\Ortu;
use App\Models\Master\Extracurricular;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EskulPesantren extends Component
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
        return view('livewire.rapor.eskul-pesantren', [
            'eskul' => PesantrenEskul::where('rapor_id', $this->idRapor)->paginate($this->paginate),
            'rapor' => Rapor::find($this->idRapor),
            'extra' => Extracurricular::all(),
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
            'eskul' => 'required',
            'predikat' => 'required',
        ])->validate();

        $data = new PesantrenEskul;
        $data->rapor_id = $this->idRapor;
        $data->extracurricular_id = $this->state['eskul'];
        $data->predikat = $this->state['predikat'];
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
        $data = PesantrenEskul::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = PesantrenEskul::find($this->idEdit);
        $this->state['eskul'] = $data->extracurricular_id;
        $this->state['predikat'] = $data->predikat;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'eskul' => 'required',
            'predikat' => 'required',
        ])->validate();

        $data = PesantrenEskul::find($this->idEdit);
        $data->extracurricular_id = $this->state['eskul'];
        $data->predikat = $this->state['predikat'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
