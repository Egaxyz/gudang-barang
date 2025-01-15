<?php
namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Get all users
    public function index()
    {
        return response()->json(Pengguna::all(), 200);
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_nama' => 'required|max:50',
            'user_pass' => 'required|min:8',
            'role' => 'required|in:superuser,admin,user,siswa',
        ]);

        $validated['user_pass'] = bcrypt($validated['user_pass']); // Hash password
        $validated['user_sts'] = $request->input('user_sts', '1');

        $pengguna = Pengguna::create($validated);

        return response()->json
        ([
            'success'=>true,
            'message' => 'Data berhasil disimpan',
            'data'=>$pengguna, 
        ]
    );
    }

    // Show a specific user
    public function show($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($pengguna, 200);
    }

    // Update a specific user
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'user_nama' => 'required|max:50',
            'role' => 'required|in:superuser,admin,user,siswa',
            'user_sts' => 'required|in:0,1',
        ]);

        $pengguna->update($validated);

        return response()->json($pengguna, 200);
    }

    // Delete a specific user
    public function destroy($id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $pengguna->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}