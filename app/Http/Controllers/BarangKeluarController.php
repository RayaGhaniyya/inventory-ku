<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestBarangKeluar;
use App\Models\BarangKeluar;
use App\Models\DetailBarangKeluar;
use App\Models\Produk;
use App\Models\StokProduk;
use App\Models\Supplier;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supplier = Supplier::get();
        $data = BarangKeluar::with('supplier')->whereHas('supplier', function ($q) {
            $q->whereNotNull('id');
        })->orderBy('date_in', 'asc')->paginate(10);
        if ($request->key) {
            $data = BarangKeluar::with('supplier')->whereHas('supplier', function ($q) {
                $q->whereNotNull('id');
            })->where('name', $request->key)->orderBy('date_in', 'asc')->paginate(10);
        }
        return view('pages.barang_keluar.index', compact('data', 'supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Supplier::get();
        $countItem = is_array(old('barang')) ? count(old('barang')) : 1;
        $barang = Produk::get();
        return view('pages.barang_keluar.create', compact("supplier", 'countItem', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestBarangKeluar $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $model = new BarangKeluar();
            $model->trx_no = 'INV/' . Carbon::now()->format('Y/m/d') . time();
            $model->supplier_id = $request->id_supplier;
            $model->date_in = $validated['date_in'];
            $model->note = $request->note;
            $model->total_qty = $request->total_qty;
            $model->grand_total = $request->grand_total;
            $model->save();

            foreach ($request->get('barang') as $key => $value) {
                $detailPesananbarangkeluar = new DetailBarangKeluar();
                $detailPesananbarangkeluar->barang_keluar_id = $model->id;
                $detailPesananbarangkeluar->produk_id = $value;
                $detailPesananbarangkeluar->qty = $request->get('qty')[$key];
                $detailPesananbarangkeluar->subtotal = $request->get('subtotal')[$key];

                $detailPesananbarangkeluar->save();

                $stokOld = StokProduk::where('produk_id', $value)->first();
                if ($stokOld->stok >= $request->get('qty')[$key]) {
                    $stokModel = StokProduk::where('produk_id', $value)->first();
                    $stokModel->stok = $stokOld->stok - $request->get('qty')[$key];
                    $stokModel->save();
                } else {
                    return redirect()->back()->with("error", 'Stok barang tidak cukup.');
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return back()->withError('Terjadi kesalahan.');
            return $e;
        } catch (QueryException $e) {
            DB::rollback();
            return $e;
            return back()->withError('Terjadi kesalahan pada database.');
        }
        DB::commit();

        return redirect()->route('barang_keluar.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(BarangKeluar $barangKeluar)
    {

        return DetailBarangKeluar::with('produk')->where('barang_keluar_id', $barangKeluar->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        //
    }

    public function ajaxSelect(Request $request)
    {
        $i = $request->no;
        $no = $request->no + 1;
        $barangs = Produk::get();
        return view('pages.barang_keluar.tr', compact('i', 'no', 'barangs'));
    }
}
