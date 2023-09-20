<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Exception;
use App\Models\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\RequestBarangMasuk;
use App\Models\DetailBarangMasuk;
use App\Models\StokProduk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supplier = Supplier::get();
        $data = BarangMasuk::with('supplier')->whereHas('supplier', function ($q) {
            $q->whereNotNull('id');
        })->orderBy('date_in', 'asc')->paginate(10);
        if ($request->key) {
            $data = BarangMasuk::with('supplier')->whereHas('supplier', function ($q) {
                $q->whereNotNull('id');
            })->where('name', $request->key)->orderBy('date_in', 'asc')->paginate(10);
        }
        return view('pages.barang_masuk.index', compact('data', 'supplier'));
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
        return view('pages.barang_masuk.create', compact("supplier", 'countItem', 'barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestBarangMasuk $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $model = new BarangMasuk();
            $model->trx_no = 'INV/' . Carbon::now()->format('Y/m/d') . time();
            $model->supplier_id = $request->id_supplier;
            $model->date_in = $validated['date_in'];
            $model->note = $request->note;
            $model->total_qty = $request->total_qty;
            $model->grand_total = $request->grand_total;
            $model->save();

            foreach ($request->get('barang') as $key => $value) {
                $detailPesananbarangmasuk = new DetailBarangMasuk();
                $detailPesananbarangmasuk->barang_masuk_id = $model->id;
                $detailPesananbarangmasuk->produk_id = $value;
                $detailPesananbarangmasuk->qty = $request->get('qty')[$key];
                $detailPesananbarangmasuk->subtotal = $request->get('subtotal')[$key];

                $detailPesananbarangmasuk->save();

                $stokOld = StokProduk::where('produk_id', $value)->first();
                $stokModel = StokProduk::where('produk_id', $value)->first();
                $stokModel->stok = $stokOld->stok + $request->get('qty')[$key];
                $stokModel->save();
            }
        } catch (Exception $e) {
            DB::rollback();
            // return back()->withError('Terjadi kesalahan.');
            return $e;
        } catch (QueryException $e) {
            DB::rollback();
            return $e;
            // return back()->withError('Terjadi kesalahan pada database.');
        }
        DB::commit();

        return redirect()->route('barang_masuk.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(BarangMasuk $barangMasuk)
    {
        return DetailBarangMasuk::with('produk')->where('barang_masuk_id', $barangMasuk->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangMasuk  $barangMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        //
    }

    public function ajaxSelect(Request $request)
    {
        $i = $request->no;
        $no = $request->no + 1;
        $barangs = Produk::get();
        return view('pages.barang_masuk.tr', compact('i', 'no', 'barangs'));
    }
}
