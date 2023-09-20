
@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Table -->
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2" action="{{ route('kategori_produk.update', $data->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="col-md-12">Nama Produk</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Ex: Minuman" name="name"
                                        class="form-control form-control-line @error('name') is-invalid @enderror"
                                        value="{{ old('name', $data->name) }}"">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success text-white">Simpan</button>
                                    <a href="{{ route('kategori_produk.index') }}" class="btn btn-secondary text-white">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table -->
    </div>
    <!-- End Container fluid  -->
@endsection
