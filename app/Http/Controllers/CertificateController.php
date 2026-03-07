<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        return response()->json(
            Certificate::orderByDesc('id')->get()
        );
    }

    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'year' => 'nullable|integer',            
            'link' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $certificate = Certificate::create($data);

        return response()->json($certificate, 201);
    }

    public function update(Request $request, $id){
        $certificate = Certificate::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'issuer' => 'sometimes|nullable|string|max:255',
            'year' => 'sometimes|nullable|integer',            
            'link' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|string',
        ]);

        $certificate->update($data);

        return response()->json($certificate);
    }

    public function destroy($id){
        $certificate = Certificate::findOrFail($id);

        $certificate->delete();

        return response()->json([
            'message' => 'Certificate deleted successfully'
        ]);
    }
}
