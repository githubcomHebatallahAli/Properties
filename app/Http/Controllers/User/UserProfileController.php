<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Requests\PhotoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Auth\UserRegisterResource;
use App\Http\Requests\User\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    public function updateProfilePhoto(PhotoRequest $request , string $id)
    {
        $User= auth()->guard('api')->user();
        if ($User->id != $id) {
            return response()->json([
                'message' => "Unauthorized to update this profile."
            ]);
        }
        if ($request->hasFile('photo')) {
            if ($User->photo) {
                Storage::disk('public')->delete($User->photo);
            }
            $photoPath = $request->file('photo')->store('User', 'public');
            $User->photo = $photoPath;

        }
        $User->save();
            return response()->json([
             'data' => new UserRegisterResource($User),
                'message' => 'Profile photo updated successfully'
            ]);
        }


    public function updateProfile(UpdateUserProfileRequest $request, string $id)
    {
        $User= auth()->guard('api')->user();
        if ($User->id != $id) {
            return response()->json([
                'message' => "Unauthorized to update this profile."
            ]);
        }
        $User = User::findOrFail($id);

        if ($request->filled('name')) {
            $User->name = $request->name;
        }

        if ($request->filled('email')) {
            $User->email = $request->email;
        }

        if ($request->filled('phoNum')) {
            $User->phoNum= $request->phoNum;
        }

        if ($request->filled('governorate')) {
            $User->governorate = $request->governorate;
        }

        if ($request->filled('address')) {
            $User->address = $request->address;
        }

        $User->save();
        return response()->json([
            'data' => new UserRegisterResource($User),
            'message' => "Update User By Id Successfully."
        ]);
    }
}
