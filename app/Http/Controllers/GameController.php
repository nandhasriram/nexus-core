<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Character;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('characters')->get();
        return response()->json(['data' => $games]);
    }

    // TARGET DELTA: Create a record (Now accepts heavy 3D files!)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'studio_name' => 'required|string|max:255',
            'status' => 'required|in:in-development,live,archived',
            'lore_description' => 'nullable|string',
            'cover_image' => 'nullable|file|max:40000', // <-- Target Golf: 20MB limit, any file type
        ]);

        if ($request->hasFile('cover_image')) {
    $file = $request->file('cover_image');
    // Force Laravel to keep the exact original name and extension (.glb)
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('covers', $filename, 'public');
    $validated['cover_image'] = $path;
}

        $game = Game::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'New Lore Engine data injected with visual asset.',
            'data' => $game
        ], 201);
    }

    // TARGET DELTA: Edit a record (Now accepts heavy 3D files!)
    public function update(Request $request, $id)
    {
        $game = Game::find($id);
        if ($game) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'studio_name' => 'required|string|max:255',
                'status' => 'required|in:in-development,live,archived',
                'lore_description' => 'nullable|string',
                'cover_image' => 'nullable|file|max:40000', // <-- Target Golf: 20MB limit, any file type
            ]);

            if ($request->hasFile('cover_image')) {
                $path = $request->file('cover_image')->store('covers', 'public');
                $validated['cover_image'] = $path;
            }

            $game->update($validated);

            if ($request->has('characters')) {
                foreach ($request->characters as $charData) {
                    $character = Character::find($charData['id']);
                    if ($character && $character->game_id == $game->id) {
                        $character->update([
                            'name' => $charData['name'],
                            'class_type' => $charData['class_type']
                        ]);
                    }
                }
            }

            return response()->json(['message' => 'Lore record modified successfully.']);
        }
        return response()->json(['message' => 'Record not found.'], 404);
    }

    public function destroy($id)
    {
        $game = Game::find($id);
        if ($game) {
            $game->delete();
            return response()->json(['message' => 'Record deleted.']);
        }
        return response()->json(['message' => 'Record not found.'], 404);
    }
}
