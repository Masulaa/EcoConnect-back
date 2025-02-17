<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the authenticated user's profile.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return response()->json(['data' => ['user' => $request->user()]], 200);
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if ($request->user()->id != $id) {
            return response()->json(['data' => ['message' => 'Forbidden']], 403);
        }

        $user = $request->user();
        $dataToUpdate = $request->only(['name', 'email']);

        if ($request->filled('newPassword')) {
            $dataToUpdate['password'] = Hash::make($request->input('newPassword'));
        }

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $dataToUpdate['picture'] = $picturePath;
        }

        $user->update($dataToUpdate);

        return response()->json(['data' => ['message' => 'Profile updated successfully']], 200);
    }

    /**
     * Delete the authenticated user's account.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->id != $id) {
            return response()->json(['data' => ['message' => 'Forbidden']], 403);
        }

        $request->user()->delete();

        return response()->json(['data' => ['message' => 'Account deleted successfully']], 200);
    }
}
