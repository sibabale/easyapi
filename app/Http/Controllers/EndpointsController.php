<?php
// app/Http/Controllers/EndpointsController.php

namespace App\Http\Controllers;

// use Inertia\Inertia;
use App\Models\Project;
use App\Models\Endpoint;
use Illuminate\Http\Request;
use App\Models\EndpointField;
use App\Rules\UniqueJsonNameRule;

class EndpointsController extends Controller
{

    public function index(Request $request, $projectId)
    {
        $projectEndpoints = Endpoint::where('project_id', $projectId)->get();
        return response()->json(['endpoints' => $projectEndpoints]);
    }

    public function show($endpointId)
    {
        $endpoint = Endpoint::with('fields')->find($endpointId);

        if ($endpoint) {
            return response()->json(['endpoint' => $endpoint]);
        } else {
            // Handle the case where the endpoint with the given ID is not found
            return response()->json(['message' => 'Endpoint not found'], 404);
        }
    }

    public function create(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is the endpoint name
            'fields' => 'required|array', // Assuming 'fields' is an array of field data
        ]);

        // Create the endpoint
        $endpoint = Endpoint::create([
            'name' => $request->input('name'),
            'project_id' => $projectId,
        ]);

        // Save the fields for the endpoint
        $fieldsData = $request->input('fields');
        foreach ($fieldsData as $field) {
            EndpointField::create([
                'endpoint_id' => $endpoint->id,
                'name' => $field['name'],
                'type' => $field['type'],
            ]);
        }

        return response()->json(['message' => 'Endpoint created successfully']);
    }

    public function store(Request $request, $projectId)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'fields' => ['required', 'array', new UniqueJsonNameRule],
        ]);

        // Create the endpoint
        $endpoint = Endpoint::create([
            'name' => $request->input('name'),
            'project_id' => $projectId,
        ]);

        // Save the fields for the endpoint
        $fieldsData = $request->input('fields');
        foreach ($fieldsData as $field) {
            EndpointField::create([
                'endpoint_id' => $endpoint->id,
                'field_attributes' => $field,
            ]);
        }

        return response()->json(['message' => 'Endpoint created successfully']);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'endpoint_id' => 'required|int',
        ]);

        $endpoint = Endpoint::findOrFail($request->input('endpoint_id'));
        $endpoint->update($validatedData);


        return response()->json([
            'endpoint' => $endpoint,
            'message' => 'Endpoint update successfully'
        ]);
    }

    public function destroy(Request $request)
    {

        $validatedData = $request->validate([
            'endpoint_id' => 'required|int',
        ]);

        $endpoint = Endpoint::findOrFail($request->input('endpoint_id'));
        // Delete the endpoint and its associated fields
        $endpoint->fields()->delete();
        $endpoint->delete();

        return response()->json([
            'message' => 'Endpoint deleted successfully'
        ]);
    }
}
