<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestKategoriProduk;
use App\Models\KategoriProduk;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = KategoriProduk::paginate(10);
        if ($request->key) {
            $data = KategoriProduk::where('name', $request->key)->paginate(10);
        }
        return view('pages.kategori_produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kategori_produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestKategoriProduk $request)
    {
        $request = $request->validated();
        try {
            $model = new KategoriProduk();
            $model->name = $request['name'];
            $model->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('kategori_produk.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriProduk $kategoriProduk)
    {
        $data = $kategoriProduk;
        return view('pages.kategori_produk.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function update(RequestKategoriProduk $request, KategoriProduk $kategoriProduk)
    {
        $request = $request->validated();
        try {
            $model = $kategoriProduk;
            $model->name = $request['name'];
            $model->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('kategori_produk.index')->withStatus('Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriProduk $kategoriProduk)
    {

        $kategoriProduk->delete();
        return redirect()->route('kategori_produk.index')->withStatus('Data berhasil dihapus.');
    }
}
