<?php
// app/Http/Controllers/EndpointFieldController.php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Endpoint;
use Illuminate\Http\Request;
use App\Models\EndpointField;
use App\Rules\UniqueFieldNameRule;
use App\Rules\UniqueFieldNameUpdateRule;
use Illuminate\Support\Facades\Auth;

class EndpointFieldController extends Controller
{
 /**
     * Update the specified endpoint field.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Validate the request
        $request->validate([
            'endpoint_id' => 'required|integer|exists:endpoints,id',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Fetch the endpoint using the provided endpoint_id
        $endpoint = Endpoint::findOrFail($request->input('endpoint_id'));

        // Check if the user owns the project associated with the endpoint
        if ($user->id !== $endpoint->project->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Fetch the fields for the given endpoint
        $fields = EndpointField::where('endpoint_id', $endpoint->id)->get();

        return response()->json($fields);
    }

    public function update(Request $request)
    {
        // Validate the update request data
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'endpoint_id' => 'required|exists:endpoints,id',
            'field_id' => 'required|exists:endpoint_fields,id',
            'field' => [
                'required',
                'array',
            ],
            'field' => [
                'required',
                'array',
                new UniqueFieldNameUpdateRule( $request->input('endpoint_id'), $request->input('field_id')),
            ]
        ]);

        $projectId = $request->input('project_id');
        $endpointId = $request->input('endpoint_id');
        $fieldId = $request->input('field_id');

        // Check if the authenticated user owns the project
        $user = Auth::user();
        $project = Project::find($projectId);

        if (!$project || $user->id !== $project->user_id) {
            return response()->json(['error' => 'Unauthorized or Project not found'], 403);
        }

        // Check if the endpoint belongs to the specified project
        $endpoint = Endpoint::where('project_id', $projectId)->find($endpointId);

        if (!$endpoint) {
            return response()->json(['error' => 'Endpoint not found or does not belong to the specified project'], 404);
        }

        // Check if the endpoint field exists
        $field = EndpointField::where('endpoint_id', $endpointId)->find($fieldId);

        if (!$field) {
            return response()->json(['error' => 'Field not found or does not belong to the specified endpoint'], 404);
        }

        // Update the endpoint field
        $field->update([
            'field_attributes' => $request->input('field'),
            // Update other fields as needed
        ]);

        return response()->json([
            'field' => $field,
            'message' => 'Endpoint field updated successfully'
        ], 200);
    }

    public function store(Request $request)
    {
        // Validate the store request data
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'endpoint_id' => 'required|exists:endpoints,id',
            'fields' => [
                'required',
                'array',
                new UniqueFieldNameRule($request->input('endpoint_id')),
            ],
        ]);

        $projectId = $request->input('project_id');
        $endpointId = $request->input('endpoint_id');

        // Check if the authenticated user owns the project
        $user = Auth::user();
        $project = Project::find($projectId);

        if (!$project || $user->id !== $project->user_id) {
            return response()->json(['error' => 'Unauthorized or Project not found'], 403);
        }

        // Check if the endpoint belongs to the specified project
        $endpoint = Endpoint::where('project_id', $projectId)->find($endpointId);

        if (!$endpoint) {
            return response()->json(['error' => 'Endpoint not found or does not belong to the specified project'], 404);
        }

        // Create endpoint fields
        foreach ($request->input('fields') as $field) {
            EndpointField::create([
                'endpoint_id' => $endpointId,
                'field_attributes' => $field,
                // Add other fields as needed
            ]);
        }

        return response()->json(['message' => 'Endpoint fields created successfully'], 201);
    }

    public function show(Request $request)
    {

        $request->validate([
            'field_id' => 'required|int',
            'project_id' => 'required|int',
            'endpoint_id' => 'required|int',
        ]);

        $fieldId = $request->input('field_id');
        $projectId = $request->input('project_id');
        $endpointId = $request->input('endpoint_id');

        $user = Auth::user();

        $project = Project::find($projectId);

        if (!$project || $user->id !== $project->user_id) {
            return response()->json(['error' => 'Unauthorized or Project not found'], 403);
        }

        $endpoint = Endpoint::where('project_id', $projectId)->find($endpointId);

        if (!$endpoint) {
            return response()->json(['error' => 'Endpoint not found or does not belong to the specified project'], 404);
        }

        $field = EndpointField::where('endpoint_id', $endpointId)->find($fieldId);

        if (!$field) {
            return response()->json(['error' => 'Field not found or does not belong to the specified endpoint'], 404);
        }

        return response()->json(['field' => $field], 200);
    }

    public function destroy(Request $request)
    {

        $request->validate([
            'field_id' => 'required|int',
            'project_id' => 'required|int',
            'endpoint_id' => 'required|int',
        ]);

        $fieldId = $request->input('field_id');
        $projectId = $request->input('project_id');
        $endpointId = $request->input('endpoint_id');

        $user = Auth::user();

        $project = Project::find($projectId);

        if (!$project || $user->id !== $project->user_id) {
            return response()->json(['error' => 'Unauthorized or Project not found'], 403);
        }

        $endpoint = Endpoint::where('project_id', $projectId)->find($endpointId);

        if (!$endpoint) {
            return response()->json(['error' => 'Endpoint not found or does not belong to the specified project'], 404);
        }

        $field = EndpointField::where('endpoint_id', $endpointId)->find($fieldId);

        if (!$field) {
            return response()->json(['error' => 'Field not found or does not belong to the specified endpoint'], 404);
        }

        $field->delete();

        return response()->json(['message' => 'Endpoint field deleted successfully'], 200);
    }



}
