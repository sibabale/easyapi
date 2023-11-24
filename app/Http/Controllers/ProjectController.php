<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Endpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::all();

        return response()->json($projects);

    }

    public function show($projectId)
    {
        $project = Project::with('endpoints')->find($projectId);

        if ($project) {
            return response()->json(['project' => $project]);
        } else {
            return response()->json(['message' => 'Project not found'], 404);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'api_version' => 'required|integer',
            'api_type' => 'required|string',
            'database' => 'required|string',
        ]);

        $user = Auth::user();

        $project = new Project([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'api_version' => $request->input('api_version'),
            'api_type' => $request->input('api_type'),
            'database' => $request->input('database'),
        ]);

        $user->projects()->save($project);

        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'api_version' => 'integer',
            'api_type' => 'in:GraphQL,Rest',
            'database' => 'string',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validatedData);

        return response()->json($project);

    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(null, 204);
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return response()->json(project, 201);
    }
}
