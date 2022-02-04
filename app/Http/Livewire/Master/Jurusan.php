<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Master\Major;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class Jurusan extends Component
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
        return view('livewire.master.jurusan', [
            'major' => Major::where('jurusan', 'like', '%'.$this->search.'%')->paginate($this->paginate)
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
            'jurusan' => 'required',
            'ket' => 'required',
        ])->validate();

        $data = new Major;
        $data->jurusan = $this->state['jurusan'];
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
        $data = Major::find($this->idHapus);

        $data->delete();

        $this->dispatchBrowserEvent('hide-form-delete');
    }

    public function edit($id)
    {
        $this->idEdit = $id;
        $data = Major::find($this->idEdit);
        $this->state['jurusan'] = $data->jurusan;
        $this->state['ket'] = $data->ket;

        $this->dispatchBrowserEvent('show-form-edit');
    }

    public function updateData()
    {
        Validator::make($this->state, [
            'jurusan' => 'required',
            'ket' => 'required',
        ])->validate();

        $data = Major::find($this->idEdit);
        $data->jurusan = $this->state['jurusan'];
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
