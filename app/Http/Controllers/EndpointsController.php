<?php
// app/Http/Controllers/EndpointsController.php

namespace App\Http\Controllers;

// use Inertia\Inertia;
use App\Models\Project;
use App\Models\Endpoint;
use App\Models\EndpointField;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:255', // Assuming 'name' is the endpoint name
            'fields' => 'required|array', // Assuming 'fields' is an array of field data
            'project_id' => 'required|int',
        ]);

        // Create the endpoint
        $endpoint = Endpoint::create([
            'name' => $request->input('name'),
            'project_id' => $request->input('project_id'),
        ]);

        // Save the fields for the endpoint
        $fieldsData = $request->input('fields');
        foreach ($fieldsData as $field) {
            EndpointField::create([
                'endpoint_id' => $endpoint->id,
                'field_attributes' => $field['field_attributes'], // Include field_attributes
            ]);
        }

        return response()->json(['message' => 'Endpoint created successfully']);
    }

    public function update(Request $request, Endpoint $endpoint)
    {
        // Validate the request data
        $request->validate([
            'endpoint_name' => 'required|string|max:255',
            'fields' => 'required|array',
        ]);

        // Update the endpoint
        $endpoint->update(['name' => $request->input('endpoint_name')]);

        // Delete existing fields and create new ones
        $endpoint->fields()->delete();
        $fields = $request->input('fields');
        foreach ($fields as $field) {
            $endpoint->fields()->create([
                'field_attributes' => $field,
            ]);
        }


        // Redirect or respond as needed
        return redirect()->route('your.redirect.route');
    }

    public function destroy(Endpoint $endpoint)
    {
        // Delete the endpoint and its associated fields
        $endpoint->fields()->delete();
        $endpoint->delete();

        // Redirect or respond as needed
        return redirect()->route('your.redirect.route');
    }
}
