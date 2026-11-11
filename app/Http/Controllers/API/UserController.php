<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function updateProfile(Request $request)
    {
        // Get the authenticated user
        $user = auth('api')->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please log in first to update your profile.',
                'code' => 401,
            ], 401);
        }

        // Validate input fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|regex:/^\+?[0-9\s\-()]{7,15}$/',
            'address' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'code' => 422,
            ],422);
        }

        // Update user profile details
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');

        $user->save();

        // Update or create user details
        $user->userDetails()->updateOrCreate(
            ['user_id' => $user->id], // Match condition
            [
                'address' => $request->input('address'),
                'town' => $request->input('town'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
            ]
        );

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Profile updated successfully.',
            'data' => [
                'name' => $user->name,
                'email' => $user->email, // Email remains read-only
                'phone' => $user->phone,
                'address' => $user->userDetails->first()?->address,
                'town' => $user->userDetails->first()?->town,
                'state' => $user->userDetails->first()?->state,
                'postal_code' => $user->userDetails->first()?->postal_code,
            ],
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validate the avatar file
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->errors()->first(),
            ]);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Generate a unique name using the user's ID and timestamp
            $avatarName = 'user-' . $user->id . '-' . time();

            // Call the Helper::fileUpload method
            $avatar = Helper::fileUpload(
                $request->file('avatar'),
                'user-avatar',
                $avatarName
            );

            // Save the avatar path to the user's profile
            $user->avatar = $avatar; // Assuming 'avatar' is a column in the users table
            $user->save();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Avatar updated successfully.',
                'avatar_url' => url($avatar),
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => 400,
            'message' => 'No avatar file uploaded.',
        ]);
    }


    public function getProfile()
    {
        // Get the authenticated user
        $user = auth('api')->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please log in first to access your profile.',
                'code' => 401,
            ], 401);
        }

        // Fetch user details

        return response()->json([
            'success' => true,
            'status' => 200,
            'userdata' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
            ],
        ]);
    }

}
