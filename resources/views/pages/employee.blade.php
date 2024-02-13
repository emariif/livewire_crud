@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Employees</h1>
        </div>
        @if (session()->has('sukses'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('sukses') }}
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Employees Create</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                wire:model='nama'>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                wire:model='email'>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                wire:model='alamat'>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            @if ($updateData == false)
                                <button type="button" class="btn btn-primary col-12" wire:click="create">
                                    Simpan
                                </button>
                            @else
                                <button type="button" class="btn btn-primary col-12" wire:click="update">
                                    Update
                                </button>
                            @endif
                            <button type="button" class="btn btn-outline-primary mt-2 col-12" wire:click="resetForm">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Employees</h4>
                        <div class="card-header-form">
                            <form wire:submit='search'>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search"
                                        wire:model.live='query'>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fas fa-search"
                                                type="submit"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if ($employee_selected_id)
                        <a wire:click="delete_confirm('')" class="btn btn-danger col-md-2 m-3" data-toggle="modal"
                            data-target="#exampleModal"><i class="fas fa-times mr-2"></i>Delete
                            {{ count($employee_selected_id) }} data</a>
                    @endif
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-striped table-md table">
                                <tr>
                                    <th>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                                class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    wire:key='{{ $employee->id }}' value="{{ $employee->id }}"
                                                    wire:model.live='employee_selected_id' class="custom-control-input"
                                                    id="checkbox-{{ $employee->id }}">
                                                <label for="checkbox-{{ $employee->id }}"
                                                    class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ $employees->firstItem() + $loop->index }}</td>
                                        <td>{{ $employee->nama }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->alamat }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a wire:click='edit({{ $employee->id }})' class="btn btn-info mr-2"><i
                                                        class="fas fa-edit mr-2"></i>Edit</a>
                                                <a wire:click='delete_confirm({{ $employee->id }})'
                                                    class="btn btn-danger" data-toggle="modal"
                                                    data-target="#exampleModal"><i
                                                        class="fas fa-times mr-2"></i>Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            @if (!empty($query))
                                                Tidak ada data yang ditemukan untuk
                                                pencarian "{{ $query }}".
                                            @endif
                                            Data masih kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">

                        <nav class="d-inline-block">
                            {{ $employees->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Really</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to continue?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button wire:click='delete' type="button" class="btn btn-danger"
                        data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
