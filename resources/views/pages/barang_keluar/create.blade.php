@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2" action="{{ route('barang_keluar.store') }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group" id="form-supplier">
                                        <label class="col-md-12">Supplier</label>
                                        <div class="col-md-12">
                                            <select name="id_supplier" class="form-control select2 " id="id_supplier"
                                                style="width:100% !important">
                                                <option value="">---Pilih Supplier---</option>
                                                @foreach ($supplier as $suppliers)
                                                    <option value="{{ $suppliers->id }}">{{ $suppliers->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Tanggal Penjualan </label>
                                        <div class="col-md-12">
                                            <input type="date" placeholder="" name="date_in"
                                                class="form-control form-control-line @error('date_in') is-invalid @enderror"
                                                value="{{ old('date_in') }}">
                                            @error('date_in')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-md-12">Catatan </label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"
                                                name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-primary text-white" id="addBarang">Tambah
                                        Barang</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap" id="table-barang-keluar">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0"></th>
                                            <th class="border-top-0">Nama Barang</th>
                                            <th class="border-top-0">Harga Barang</th>
                                            <th class="border-top-0">Kuantitas Barang</th>
                                            <th class="border-top-0">Subotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="barang-keluar">
                                        @php
                                            $no = 0;
                                        @endphp
                                        @for ($i = 0; $i < $countItem; $i++)
                                            @php
                                                $no++;
                                            @endphp
                                            @include('pages.barang_keluar.tr', [
                                                'no' => $no,
                                                'i' => $i,
                                                'barangs' => $barang,
                                            ])
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>
                                                <input type="number" id="total_qty" name="total_qty" value="0"
                                                    class="form-control" placeholder="Total Barang" readonly>
                                            </td>
                                            <td>
                                                <input type="number" id="grandtotal" name="grand_total" value="0"
                                                    class="form-control" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success text-white">Simpan</button>
                                    <a href="{{ route('barang_keluar.index') }}"
                                        class="btn btn-secondary text-white">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        var addButton = $('#addBarang');
        var wrapper = $('#barang-keluar');
        $(addButton).click(function() {
            var no = parseInt($(".row-item:last").attr('data-no'))
            $.ajax({
                type: 'get',
                url: "{{ url('ajax-barang-keluar') }}",
                data: {
                    no: no
                },
                success: function(data) {
                    wrapper.append(data)
                    no++
                }
            })
        });

        function removeTr(no) {
            var selector = '.row-item[data-no="' + no + '"]';
            $(selector).remove()
            grandtotal()
        }

        function subtotal(no) {
            var harga = $('#harga' + no).val();
            var qty = $('#qty' + no).val();
            $('#subtotal' + no).val(parseInt(harga * qty))
            grandtotal()
        }

        function grandtotal() {
            var table = document.getElementById("table-barang-keluar");
            var tbodyRowCount = table.tBodies[0].rows.length;
            var total_qty = 0;
            var grandtotal = 0;
            $('.subtotal').each(function() {
                grandtotal += parseInt($(this).val())
            });
            $('#grandtotal').val(grandtotal);
            $('#total_qty').val(tbodyRowCount);
        }
    </script>
    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
@endpush
