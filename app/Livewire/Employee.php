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

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $employees = ModelsEmployee::where('nama', 'like', '%'.$this->query.'%')->latest()->paginate(5);
        return view('pages.employee', compact('employees'))->layout('layouts.app');
    }

    public function create()
    {
        $validated = $this->validate([
            'nama'  => 'required',
            'email' => 'required',
            'alamat'=> 'required',
        ]);

        ModelsEmployee::create($validated);

        session()->flash('sukses', 'Data berhasil ditambahkan');

        $this->reset();
    }
}
