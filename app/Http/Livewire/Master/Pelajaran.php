<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Master\Lesson;
use App\Models\Master\Group;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class Pelajaran extends Component
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
        return view('livewire.master.pelajaran', [
            'lesson' => Lesson::where('nama', 'like', '%'.$this->search.'%')->where('kelas', 'X')->paginate($this->paginate),
            'group' => Group::all()
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
            'kode' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jenis' => 'required',
        ])->validate();

        $data = new Lesson;
        $data->group_id = $this->state['jenis'];
        $data->kelas = $this->state['kelas'];
        $data->kode = $this->state['kode'];
        $data->nama = $this->state['nama'];
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
        $data = Lesson::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Lesson::find($this->idEdit);
        $this->state['jenis'] = $data->group_id;
        $this->state['kelas'] = $data->kelas;
        $this->state['kode'] = $data->kode;
        $this->state['nama'] = $data->nama;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'kode' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jenis' => 'required',
        ])->validate();

        $data = Lesson::find($this->idEdit);
        $data->group_id = $this->state['jenis'];
        $data->kelas = $this->state['kelas'];
        $data->kode = $this->state['kode'];
        $data->nama = $this->state['nama'];
        $data->save();

        $this->resetInput();

        $this->dispatchBrowserEvent('hide-form-edit');
    }

    private function resetInput()
    {
        $this->state = null;
    }
}
