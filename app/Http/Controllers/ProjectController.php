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
        // Get all projects
        $projects = Project::all();

        // Return a view or JSON response as needed
        return response()->json($projects);

    }

    public function create()
    {
        // Using Inertia.js to return an Inertia response
        // return Inertia::render('Projects/Create');
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

        // Create a new project with form inputs
        $project = new Project([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'api_version' => $request->input('api_version'),
            'api_type' => $request->input('api_type'),
            'database' => $request->input('database'),
        ]);

        $user->projects()->save($project);

         // Return a view or JSON response as needed
        return response()->json($project, 201);
        // return redirect()->route('projects.index');
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'api_version' => 'integer',
            'api_type' => 'in:GraphQL,Rest',
            'database' => 'string',
        ]);

        // Update the project
        $project = Project::findOrFail($id);
        $project->update($validatedData);

        // Return a view or JSON response as needed
        return response()->json($project);
        // return redirect()->route('projects.index');

    }

    public function destroy($id)
    {
        // Delete a project by ID
        $project = Project::findOrFail($id);
        $project->delete();

        // Return a view or JSON response as needed
        return response()->json(null, 204);
        // return redirect()->route('projects.index');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return response()->json(project, 201);

        // Using Inertia.js to return an Inertia response
        // return Inertia::render('Projects/Edit', [
        //     'project' => $project,
        // ]);
    }
}
