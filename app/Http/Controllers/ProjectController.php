<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(
            Project::orderByDesc('id')->get()
        );
    }

    // 🔹 إضافة مشروع جديد
    public function store(Request $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'year' => $request->year
        ]);

        return response()->json($project, 201);
    }

    // 🔹 حذف مشروع
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }

    

  
   public function update(Request $request, $id)
{
    $project = Project::findOrFail($id);

    $data = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'year' => 'sometimes|required|integer',
        // إذا تبين تعدلين غيرها بعدين أضيفيها هنا
    ]);

    $project->update($data);

    return response()->json($project);
}
}
