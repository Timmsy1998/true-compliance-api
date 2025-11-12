<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * GET /api/certificate
     * Display a listing of the resource.
     */
    public function index()
    {
        return Certificate::all();
    }

    /**
     * POST /api/certificate
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'stream_name' => 'required|string|max:255',
            'property_id' => 'required|exists:properties,id',
            'issue_date' => 'required|date_format:Y-m-d',
            'next_due_date' => 'required|date_format:Y-m-d|after_or_equal:issue_date',
        ]);

        $certificate = Certificate::create($validatedData);

        return response()->json($certificate, 201);
    }

    /**
     * GET /api/certificate/{id}
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        $certificate->load('property');
        return $certificate;
    }

    /**
     * GET /api/certificate/{certificate}/note
     * Returns the notes of a certificate.
     */
    public function getNotes(Certificate $certificate)
    {
        return $certificate->notes;
    }

    /**
     * POST /api/certificate/{certificate}/note
     * Creates a note for a certificate.
     */
    public function storeNote(Request $request, Certificate $certificate)
    {
        $validatedData = $request->validate([
            'note' => 'required|string',
        ]);

        $note = $certificate->notes()->create([
            'note' => $validatedData['note']
        ]);

        return response()->json($note, 201);
    }
}
