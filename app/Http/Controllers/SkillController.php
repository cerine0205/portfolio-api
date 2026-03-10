<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                'skills' => Skill::orderBy('display_order')->get()
            ]
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $skill = Skill::create($data);

        return response()->json($skill, 201);
    }


    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully'
        ]);
    }
}
