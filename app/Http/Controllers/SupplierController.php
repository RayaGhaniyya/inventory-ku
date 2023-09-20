<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Supplier::paginate(10);
        if ($request->key) {
            $data = Supplier::where('name', $request->key)->paginate(10);
        }
        return view('pages.supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
        //     $data = request()->validate([
        //         'nama' => 'required'
        //     ]);
        //     $model = new Supplier();
        //     $model->name = $data['nama'];
        //     $model->save();
        // } catch (Exception $e) {
        //     return back()->withError('Terjadi kesalahan.');
        // } catch (QueryException $e) {
        //     return back()->withError('Terjadi kesalahan pada database.');
        // }

        // return redirect()->route('supplier.index')->withStatus('Data berhasil disimpan.');

        $data = request()->validate([
            'nama' => 'required|unique:suppliers,nama'
        ]);

        Supplier::create($data);

        return redirect()->route('supplier.index')->withStatus('Data berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $data = $supplier;
        return view('pages.supplier.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        // $request = $request->validated();
        try {
            $model = $supplier;
            $model->name = $request['name'];
            $model->save();
        } catch (Exception $e) {
            return back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database.');
        }

        return redirect()->route('supplier.index')->withStatus('Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->withStatus('Data berhasil dihapus.');
    }
}
