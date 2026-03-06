<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    // list projects
    public function index()
    {
        return response()->json(
            Project::with('tags')->orderByDesc('id')->get()
        );
    }

    // create project
    public function store(Request $request)
    {

        // check if the request data is valid and store it in $data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer',

            'featured' => 'nullable|boolean',
            'status' => 'nullable|string',
            'team_size' => 'nullable|integer',

            'tech_stack' => 'nullable|array',  // tech_stack must be an array ["react", "Laravel"]
            'tech_stack.*' => 'string', // each tech_stack must be a string  'react'

            'image' => 'nullable|string', // image link must be a string  'https://example.com/image.jpg'

            'problem' => 'nullable|string',
            'solution' => 'nullable|string',

            'tags' => 'nullable|array',  // tags must be an array ["frontend", "backend"]
            'tags.*' => 'string' // each tag must be a string  'backend'
        ]);


        // create project from checked data in $data
        $project = Project::create($data);

        // Ensure tags exist and collect their ids to link to the project
        $tagIds = [];
        foreach ($data['tags'] ?? [] as $tagName) {

            $tag = Tag::firstOrCreate([
                'name' => $tagName ]);

            $tagIds[] = $tag->id;
        }


        // connect tags to the project in the pivot table
        $project->tags()->sync($tagIds);


        // return the created project
        return response()->json(
            $project->load('tags'),
            201
        );
    }


    // edit project
   public function update(Request $request, $id)
{
    // find the project and store it in $project
    $project = Project::findOrFail($id);

    // check if the request data is valid and store it in $data
    $data = $request->validate([

    // sometimes means that the field is optional 
    // sometimes/nullable means that the field is optional, and if it exists it can be null
    // sometimes|required means the field is optional, but if it is sent it must not be empty and must match the validation rules

        'name' => 'sometimes|required|string|max:255', // optional, but if sent it must be a non-empty string
        'description' => 'sometimes|required|string', 
        'year' => 'sometimes|required|integer', 

        'featured' => 'sometimes|boolean', // optional, but if it exists it cannot be null and must be a boolean
        'status' => 'sometimes|string',
        'team_size' => 'sometimes|integer',

        'tech_stack' => 'sometimes|array',
        'tech_stack.*' => 'string',

        'image' => 'sometimes|nullable|string', // optional, and can be null if user wants to remove it
        'problem' => 'sometimes|nullable|string',
        'solution' => 'sometimes|nullable|string',

        'tags' => 'sometimes|array',
        'tags.*' => 'string'
    ]);

    // update the project using the validated data in $data
    $project->update($data);


    // Ensure tags exist and collect their ids to link to the project
    if (array_key_exists('tags', $data)) {
        $tagIds = [];

        foreach ($data['tags'] as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName
            ]);

            $tagIds[] = $tag->id;
        }


        // connect tags to the project in the pivot table
        $project->tags()->sync($tagIds);
    }

    // return the updated project
    return response()->json(
        $project->load('tags')
    );
}

      // delete project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }

}
