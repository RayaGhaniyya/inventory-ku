@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <!-- Table -->
        <div class="row">
        </div>
        <!-- column -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="d-md-flex">
                        <div>
                            <a href="{{ route('barang_keluar.create') }}" class="btn btn-primary">Tambah Data</a>
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
                                    <th class="border-top-0">Nomor Transaksi</th>
                                    <th class="border-top-0">Tanggal Penjualan</th>
                                    <th class="border-top-0">Catatan</th>
                                    <th class="border-top-0">Supplier</th>
                                    <th class="border-top-0">Total Barang</th>
                                    <th class="border-top-0">Grandtotal</th>
                                    <th class="border-top-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 1;
                                @endphp
                                @if (count($data) != 0)
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $id++ }}</td>
                                            <td>{{ $item->trx_no }}</td>
                                            <td>{{ $item->date_in }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>{{ $item->supplier->nama }}
                                            </td>
                                            <td>{{ $item->total_qty }}</td>
                                            <td>{{ number_format($item->grand_total, 0, ',', '.') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm text-white"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    onclick="detail({{ $item->id }})">Detail</a>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <table class="table mb-0 table-hover align-middle text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kuantitas</th>
                                <th>Harga Barang</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal-detail">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus?',
                showCancelButton: true,
                icon: 'warning',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete').submit();

                }
            })
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function detail(id) {
            $('#modal-detail').empty();
            $.ajax({
                type: "get",
                url: "{{ url('barang_keluar') }}/" + id,
                dataType: "json",
                success: function(response) {
                    $.each(response, function(i, v) {
                        $('#modal-detail').append(
                            `
                    <tr>
                        <td>${v.produk.name}</td>
                        <td>${parseFloat(v.qty)}</td>
                        <td>${formatRupiah((parseFloat(v.subtotal)/parseFloat(v.qty)).toString())}</td>
                        <td>${formatRupiah(parseFloat(v.subtotal).toString())}</td>
                    </tr>
                    `
                        );
                    });
                }
            });
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
