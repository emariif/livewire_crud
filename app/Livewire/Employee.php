<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama;
    public $email;
    public $alamat;

    public $query = '';

    public $updateData = false;
    public $employee_id;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $employees = ModelsEmployee::where('nama', 'like', '%'.$this->query.'%')
            ->orWhere('email', 'like', '%'.$this->query.'%')
            ->orWhere('alamat', 'like', '%'.$this->query.'%')
            ->latest()->paginate(5);
        return view('pages.employee', compact('employees'))->layout('layouts.app');
    }

    public function resetForm() {
        $this->reset();
    }

    public function create()
    {
        $validated = $this->validate([
            'nama'  => 'required',
            'email' => 'required|email',
            'alamat'=> 'required',
        ]);

        ModelsEmployee::create($validated);

        session()->flash('sukses', 'Data berhasil ditambahkan');

        $this->reset();
    }

    public function edit($id) {
        $employee = ModelsEmployee::find($id);

        $this->nama = $employee->nama;
        $this->email = $employee->email;
        $this->alamat = $employee->email;

        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update() {
        $validated = $this->validate([
            'nama'  => 'required',
            'email' => 'required|email',
            'alamat' => 'required'
        ]);

        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);

        session()->flash('sukses', 'Data berhasil di update');

        $this->reset();
    }

    public function delete() {
        $id = $this->employee_id;
        ModelsEmployee::find($id)->delete();
        session()->flash('sukses', 'Data berhasil di hapus');
        $this->reset();
    }

    public function delete_confirm($id) {
        $this->employee_id = $id;
    }
}
