<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Http\Requests\RequestProduk;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\StokProduk;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Produk::with('satuan', 'kategori', 'stok')->paginate(10);
        if ($request->key) {
            $data = Produk::with('satuan', 'kategori', 'stok')->where('name', $request->key)->paginate(10);
        }
        return view('pages.produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuans = Satuan::get();
        $kategori = KategoriProduk::get();
        return view('pages.produk.create', compact('satuans', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestProduk $request)
    {
        $request = $request->validated();
        try {
            $model = new Produk;
            $model->satuan_id = $request['id_satuan'];
            $model->kategori_id = $request['id_kategori'];
            $model->name = $request['name'];
            $model->save();

            $stokModel = new StokProduk();
            $stokModel->produk_id = $model->id;
            $stokModel->stok = 0;
            $stokModel->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
            return $e;
        } catch (QueryException $e) {
            return $e;
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('produk.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $satuans = Satuan::get();
        $kategori = KategoriProduk::get();
        $data = $produk;
        return view('pages.produk.edit', compact('data', 'satuans', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(RequestProduk $request, Produk $produk)
    {
        $request = $request->validated();
        try {
            $model = $produk;
            $model->satuan_id = $request['id_satuan'];
            $model->kategori_id = $request['id_kategori'];
            $model->name = $request['name'];
            $model->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('produk.index')->withStatus('Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->withStatus('Data berhasil dihapus.');
    }
}
