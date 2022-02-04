<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ortu;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class OrangTua extends Component
{
    public $state = [];
    public $idHapus = null;
    public $idEdit = null;

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

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $cari_nama = User::where('name', 'like', '%'.$this->search.'%')->get('id');

        return view('livewire.orang-tua', [
            'ortu' => Ortu::whereIn('user_id', $cari_nama)->paginate($this->paginate)
        ]);
    }

    public function addNew()
    {
        $this->resetInput();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createData()
    {
        // dd((int)$this->state['nett'] + (int)$this->state['sales']);

        Validator::make($this->state, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'jk' => ['required'],
            'kerja' => ['required'],
            'penghasilan' => ['required'],
            'hp' => ['required'],
            'alamat' => ['required'],
        ])->validate();

        $user = User::create([
            'name' => $this->state['nama'],
            'email' => $this->state['email'],
            'password' => bcrypt($this->state['password']),
        ]);

        $user->attachRole('orang_tua');

        $data = new Ortu;
        $data->user_id = $user->id;
        $data->jk = $this->state['jk'];
        $data->kerja = $this->state['kerja'];
        $data->penghasilan = $this->state['penghasilan'];
        $data->hp = $this->state['hp'];
        $data->alamat = $this->state['alamat'];
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
        $ortu = Ortu::find($this->idHapus);

        $data = User::find($ortu->user_id);
        $data->detachRole('orang_tua');
        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Ortu::find($this->idEdit);
        $this->state['nama'] = $data->user->name;
        $this->state['email'] = $data->user->email;
        $this->state['password'] = null;
        $this->state['jk'] = $data->jk;
        $this->state['kerja'] = $data->kerja;
        $this->state['penghasilan'] = $data->penghasilan;
        $this->state['hp'] = $data->hp;
        $this->state['alamat'] = $data->alamat;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        $ortu = Ortu::find($this->idEdit);
        $user = User::find($ortu->user_id);

        if($this->state['email'] !=  $user->email) {
            Validator::make($this->state, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ])->validate();
        }

        if($this->state['password'] != null) {
            Validator::make($this->state, [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ])->validate();

            $user->password = bcrypt($this->state['password']);
        }

        Validator::make($this->state, [
            'nama' => ['required', 'string', 'max:255'],
            'jk' => ['required'],
            'kerja' => ['required'],
            'penghasilan' => ['required'],
            'hp' => ['required'],
            'alamat' => ['required'],
        ])->validate();

        $user->name = $this->state['nama'];
        $user->email = $this->state['email'];
        $user->save();

        $ortu->jk = $this->state['jk'];
        $ortu->kerja = $this->state['kerja'];
        $ortu->penghasilan = $this->state['penghasilan'];
        $ortu->hp = $this->state['hp'];
        $ortu->alamat = $this->state['alamat'];
        $ortu->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
