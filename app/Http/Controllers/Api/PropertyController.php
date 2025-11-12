<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * GET /api/property
     * Display a listing of the resource.
     */
    public function index()
    {
        return Property::all();
    }

    /**
     * POST /api/property
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'organisation' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'parent_property_id' => 'nullable|exists:properties,id',
            'uprn' => 'required|string|max:255',
            'address' => 'required|string',
            'town' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:255',
            'live' => 'required|boolean',
        ]);

        $property = Property::create($validatedData);

        return response()->json($property, 201);
    }

    /**
     * GET /api/property/{id}
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load('certificates', 'notes');
        return $property;
    }

    /**
     * PATCH /api/property/{id}
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validatedData = $request->validate([
            'organisation' => 'sometimes|required|string|max:255',
            'property_type' => 'sometimes|required|string|max:255',
            'parent_property_id' => 'nullable|exists:properties,id',
            'uprn' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'town' => 'nullable|string|max:255',
            'postcode' => 'sometimes|required|string|max:255',
            'live' => 'sometimes|required|boolean',
        ]);

        $property->update($validatedData);

        return response()->json($property);
    }

    /**
     * DELETE /api/property/{id}
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(null, 204);
    }

    /**
     * GET /api/property/{property}/certificate
     * Returns the certificates of a property.
     */
    public function getCertificates(Property $property)
    {
        return $property->certificates;
    }

    /**
     * GET /api/property/{property}/note
     * Returns the notes of a property.
     */
    public function getNotes(Property $property)
    {
        return $property->notes;
    }

    /**
     * POST /api/property/{property}/note
     * Creates a note for a property.
     */
    public function storeNote(Request $request, Property $property)
    {
        $validatedData = $request->validate([
            'note' => 'required|string',
        ]);

        $note = $property->notes()->create([
            'note' => $validatedData['note']
        ]);

        return response()->json($note, 201);
    }
}
