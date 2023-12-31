<?php

namespace App\Http\Controllers;

use App\Models\Aspect;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AspectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $attributes = Aspect::paginate(10);
        $domains = Domain::all();
        return view('pages.aspect', compact('attributes','domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'aspect_name' => 'required',
                'domain_id' => 'required'
            ]);

            // Perform other actions or additional validations if needed before creating the aspect

            Aspect::create($request->all());

            return redirect()->route('aspect')
                ->with('success', 'Aspek berhasil dibuat');
        } catch (ValidationException $e) {
            // Handle validation exception (form validation errors)
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., database error)
            return redirect()->back()
                ->with('error', 'Gagal membuat aspek. Silahkan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspect $aspect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspect $aspect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspect $aspect): RedirectResponse
    {
        try {
            $request->validate([
                'aspect_name' => 'required'
            ]);
            $aspect->update($request->all());
            return redirect()->route('aspect')
                ->with('success','Aspek berhasil dibuat');
        } catch (ValidationException $e) {
            // Handle validation exception (form validation errors)
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., database error)
            return redirect()->back()
                ->with('error', 'Gagal update aspek. Silahkan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspect $aspect): RedirectResponse
    {
        try {
            $aspect->delete();
            return redirect()->route('aspect')
                ->with('success','Aspek berhasil dihapus');
        } catch (ValidationException $e) {
            // Handle validation exception (form validation errors)
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., database error)
            return redirect()->back()
                ->with('error', 'Gagal menghapus aspek. Silahkan coba lagi.');
        }
    }

    public function searchAspect(Request $request)
    {
        $keyword = $request->input('keyword');

        $attributes = Aspect::join('domains', 'domains.id', '=', 'aspects.domain_id')
            ->select('aspects.*', 'domains.domain_name')
            ->where(function ($query) use ($keyword) {
                $query->where('aspect_name', 'LIKE', '%' . $keyword . '%'); // Add a semicolon at the end of this line
            })
            ->paginate(10);

        $domains = Domain::all();
        return view('pages.aspect', compact('attributes', 'domains'));
    }
}
