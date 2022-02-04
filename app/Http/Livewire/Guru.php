<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Master\Position;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class Guru extends Component
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

        return view('livewire.guru', [
            'guru' => Teacher::whereIn('user_id', $cari_nama)->paginate($this->paginate),
            'jabatan' => Position::all()
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
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nip' => ['required'],
            'kode' => ['required'],
            'tempat_lahir' => ['required'],
            'tgl_lahir' => ['required'],
            'jk' => ['required'],
            'status_merital' => ['required'],
            'agama' => ['required'],
            'warganegara' => ['required'],
            'hp' => ['required'],
            'alamat' => ['required'],
            'jabatan' => ['required'],
            'pendidikan' => ['required'],
            'status_pegawai' => ['required'],
        ])->validate();

        $user = User::create([
            'name' => $this->state['nama'],
            'email' => $this->state['email'],
            'password' => bcrypt($this->state['password']),
        ]);

        $user->attachRole('guru');

        $data = new Teacher;
        $data->user_id          = $user->id;
        $data->position_id      = $this->state['jabatan'];
        $data->nip              = $this->state['nip'];
        $data->kode              = $this->state['kode'];
        $data->pendidikan       = $this->state['pendidikan'];
        $data->status_pegawai   = $this->state['status_pegawai'];
        $data->tempat_lahir     = $this->state['tempat_lahir'];
        $data->tgl_lahir        = $this->state['tgl_lahir'];
        $data->jk               = $this->state['jk'];
        $data->status_merital   = $this->state['status_merital'];
        $data->agama            = $this->state['agama'];
        $data->warganegara      = $this->state['warganegara'];
        $data->hp               = $this->state['hp'];
        $data->alamat           = $this->state['alamat'];
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
        $teacher = Teacher::find($this->idHapus);

        $data = User::find($teacher->user_id);
        $data->detachRole('guru');
        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Teacher::find($this->idEdit);
        $this->state['nama'] = $data->user->name;
        $this->state['email'] = $data->user->email;
        $this->state['password'] = null;
        $this->state['nip'] = $data->nip;
        $this->state['kode'] = $data->kode;
        $this->state['tempat_lahir'] = $data->tempat_lahir;
        $this->state['tgl_lahir'] = $data->tgl_lahir;
        $this->state['jk'] = $data->jk;
        $this->state['status_merital'] = $data->status_merital;
        $this->state['agama'] = $data->agama;
        $this->state['warganegara'] = $data->warganegara;
        $this->state['hp'] = $data->hp;
        $this->state['alamat'] = $data->alamat;
        $this->state['jabatan'] = $data->position_id;
        $this->state['pendidikan'] = $data->pendidikan;
        $this->state['status_pegawai'] = $data->status_pegawai;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        // dd($this->state);
        $teacher = Teacher::find($this->idEdit);
        $user = User::find($teacher->user_id);

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
            'nip' => ['required'],
            'kode' => ['required'],
            'tempat_lahir' => ['required'],
            'tgl_lahir' => ['required'],
            'jk' => ['required'],
            'status_merital' => ['required'],
            'agama' => ['required'],
            'warganegara' => ['required'],
            'hp' => ['required'],
            'alamat' => ['required'],
            'jabatan' => ['required'],
            'pendidikan' => ['required'],
            'status_pegawai' => ['required'],
        ])->validate();

        $user->name = $this->state['nama'];
        $user->email = $this->state['email'];
        $user->save();

        $teacher->position_id      = $this->state['jabatan'];
        $teacher->nip              = $this->state['nip'];
        $teacher->kode              = $this->state['kode'];
        $teacher->pendidikan       = $this->state['pendidikan'];
        $teacher->status_pegawai   = $this->state['status_pegawai'];
        $teacher->tempat_lahir     = $this->state['tempat_lahir'];
        $teacher->tgl_lahir        = $this->state['tgl_lahir'];
        $teacher->jk               = $this->state['jk'];
        $teacher->status_merital   = $this->state['status_merital'];
        $teacher->agama            = $this->state['agama'];
        $teacher->warganegara      = $this->state['warganegara'];
        $teacher->hp               = $this->state['hp'];
        $teacher->alamat           = $this->state['alamat'];
        $teacher->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
