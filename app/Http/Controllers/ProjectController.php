<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{

    // list projects
    public function index()
    {
        return response()->json(
            Project::with('tags', 'screenshots')->orderByDesc('id')->get()
        );
    }

    // create project
    public function store(Request $request)
    {

        // check if the request data is valid and store it in $data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer|min:2000|max:2100',

            'featured' => 'nullable|boolean',
            'status' => 'nullable|string',
            'team_size' => 'nullable|integer|min:1',

            'tech_stack' => 'nullable|array',  // tech_stack must be an array ["react", "Laravel"]
            'tech_stack.*' => 'string', // each tech_stack must be a string  'react'

            'image' => 'nullable|url', // image link must be a url  'https://example.com/image.jpg'

            'problem' => 'nullable|string',
            'solution' => 'nullable|string',

            'repo' => 'nullable|url',
            'frontend_repo' => 'nullable|url',
            'backend_repo' => 'nullable|url',
            'live_url' => 'nullable|url',
            'report_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'presentation_url' => 'nullable|url',

            'role' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',

            'challenges' => 'nullable|string',
            'results' => 'nullable|string',

            'features' => 'nullable|array',
            'features.*' => 'string',

            'architecture' => 'nullable|string',
            'architecture_image' => 'nullable|url',

            'refactor_notes' => 'nullable|string',

            'tags' => 'nullable|array',  // tags must be an array ["frontend", "backend"]
            'tags.*' => 'string', // each tag must be a string  'backend'

            'screenshots' => 'nullable|array',
            'screenshots.*' => 'url'
        ]);


        // create project from checked data in $data without tags and screenshots
        $project = Project::create(
            Arr::except($data, ['tags', 'screenshots'])
        );

        // Ensure tags exist and collect their ids to link to the project
        $tagIds = [];
        foreach ($data['tags'] ?? [] as $tagName) {

            $tag = Tag::firstOrCreate([
                'name' => $tagName
            ]);

            $tagIds[] = $tag->id;
        }


        // connect tags to the project in the pivot table
        $project->tags()->sync($tagIds);


        // create screenshots and link them to the project directly in screenshots table
        foreach ($data['screenshots'] ?? [] as $image) {
            $project->screenshots()->create([
                'image' => $image
            ]);
        }

        // return the created project
        return response()->json(
            $project->load(['tags', 'screenshots']),
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
            'year' => 'sometimes|required|integer|min:2000|max:2100',

            'featured' => 'sometimes|boolean', // optional, but if it exists it cannot be null and must be a boolean
            'status' => 'sometimes|string',
            'team_size' => 'sometimes|integer|min:1',

            'tech_stack' => 'sometimes|array',
            'tech_stack.*' => 'string',

            'image' => 'sometimes|nullable|url', // optional, and can be null if user wants to remove it
            'problem' => 'sometimes|nullable|string',
            'solution' => 'sometimes|nullable|string',

            'repo' => 'sometimes|nullable|url',
            'frontend_repo' => 'sometimes|nullable|url',
            'backend_repo' => 'sometimes|nullable|url',
            'live_url' => 'sometimes|nullable|url',
            'report_url' => 'sometimes|nullable|url',
            'demo_url' => 'sometimes|nullable|url',
            'presentation_url' => 'sometimes|nullable|url',

            'role' => 'sometimes|nullable|string|max:255',
            'duration' => 'sometimes|nullable|string|max:255',
            'type' => 'sometimes|nullable|string|max:255',

            'challenges' => 'sometimes|nullable|string',
            'results' => 'sometimes|nullable|string',

            'features' => 'sometimes|array',
            'features.*' => 'string',

            'architecture' => 'sometimes|nullable|string',
            'architecture_image' => 'sometimes|nullable|url',

            'refactor_notes' => 'sometimes|nullable|string',

            'tags' => 'sometimes|array',
            'tags.*' => 'string',

            'screenshots' => 'sometimes|array',
            'screenshots.*' => 'url'
        ]);

        // update the project using the validated data in $data without tags and screenshots
        $project->update(
            Arr::except($data, ['tags', 'screenshots'])
        );


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

        if (array_key_exists('screenshots', $data)) {

            //delete old screenshots
            $project->screenshots()->delete();

            // add new screenshots
            foreach ($data['screenshots'] as $image) {
                $project->screenshots()->create([
                    'image' => $image
                ]);
            }
        }

        // return the updated project
        return response()->json(
            $project->load(['tags', 'screenshots'])
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
