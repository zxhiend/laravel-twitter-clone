<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Get the authenticated user
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Get a specific user by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the authenticated user's profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $this->userService->update(auth()->id(), $request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Update the authenticated user's password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->userService->updatePassword(auth()->id(), $request->all());

            return response()->json([
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }
    }

    /**
     * Delete user account
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $this->userService->deleteAccount(auth()->user());

        return response()->json(['message' => 'Account deleted successfully']);
    }
} 