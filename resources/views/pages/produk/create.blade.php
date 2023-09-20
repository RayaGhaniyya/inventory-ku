@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Table -->
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2" action="{{ route('produk.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">Satuan Produk</label>
                                <div class="col-md-12">
                                    <select name="id_satuan" class="form-control select2" id="id_satuan1">
                                        <option value="">---Pilih Satuan---</option>
                                        @foreach ($satuans as $satuan)
                                            <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Kategori Produk</label>
                                <div class="col-md-12">
                                    <select name="id_kategori" class="form-control select2" id="id_kategori1">
                                        <option value="">---Pilih Kategori---</option>
                                        @foreach ($kategori as $kategoris)
                                            <option value="{{ $kategoris->id }}">{{ $kategoris->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Nama </label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="..." name="name"
                                        class="form-control form-control-line @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}">
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
                                    <a href="{{ route('produk.index') }}" class="btn btn-secondary text-white">Kembali</a>
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
