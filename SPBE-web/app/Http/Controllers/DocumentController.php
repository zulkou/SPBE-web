<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Indicator;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(): View
    {
        $attributes = Document::join('indicators','documents.indicator_id','=','indicators.id')
            ->join('aspects','indicators.aspect_id','=','aspects.id')
            ->join('domains','aspects.domain_id','=','domains.id')
            ->join('users','documents.user_id','=','users.id')
            ->select('documents.*','domains.domain_name','aspects.aspect_name','indicators.indicator_name','users.name as username')
            ->orderBy('updated_at','desc')
            ->paginate(10);
        $usernames = User::all();
        $indicators = Indicator::all();
    return view('pages.document', compact('attributes','usernames','indicators'));
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
        $request->validate([
            'doc_name'=>'required',
            'user_id'=>'required',
            'indicator_id'=>'required',
            'file'=>'nullable|file'
        ]);

        $document = new Document();
        $document->doc_name = $request->input('doc_name');
        $document->indicator_id = $request->input('indicator_id');
        $document->user_id = $request->input('user_id');

        if ($request->hasFile('file')) {
            Storage::makeDirectory(public_path('uploads'));
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $document->upload_path = $path;
        }

        $document->save();
        return redirect()->route('document')
            ->with('success', 'Dokumen berhasil diupload');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('pages.tables',compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $request->validate([
            'doc_name'=>'required',
            'file'=>'nullable|file'
        ]);

        $document->doc_name = $request->input('doc_name');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            if ($document->upload_path) {
                Storage::delete($document->upload_path);
            }

            $document->upload_path = $path;
        }

        $document->save();

        return redirect()->route('document')
            ->with('success', 'Dokumen berhasil diupload');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document): RedirectResponse
    {
        if ($document->upload_path) {
            Storage::disk('public')->delete($document->upload_path);
        }
        $document->delete();
        return redirect()->route('document')
            ->with('success', 'Dokumen berhasil dihapus');
    }
}
