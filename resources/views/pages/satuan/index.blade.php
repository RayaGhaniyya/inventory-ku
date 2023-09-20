@extends('layouts.master')
@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Table -->
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex">
                            <div>
                                <a href="{{ route('satuan.create') }}" class="btn btn-primary">Tambah Data</a>
                            </div>
                            <div class="ms-auto">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="key" name="key"
                                                value="{{ Request::get('key') }}" placeholder="Cari data . . . .">
                                        </div>
                                        <div class="col-md-4">

                                            <button type="submit" class="btn btn-success text-white">Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Nama</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @if (count($data) != 0)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <a href="{{ route('satuan.edit', $item->id) }}"
                                                        class="btn btn-success btn-sm text-white">Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white"
                                                        onclick="hapus({{ $item->id }})">Hapus</a>
                                                    <form action="{{ route('satuan.destroy', $item->id) }}" method="post"
                                                        id="delete">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <h3>Tidak ada data.</h3>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table -->
    </div>
    <!-- End Container fluid  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js">
    </script>
    <script>
        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus?',
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#delete').submit();

                }
            })
        }
    </script>
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('status') }}',
            })
        </script>
    @endif
@endsection
