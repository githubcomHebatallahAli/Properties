<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HandlesAuthorizationTrait
{
    protected function authorizeSale($model)
    {
        $user = Auth::guard('admin')->user() ??
                Auth::guard('broker')->user() ??
                Auth::guard('api')->user();

        if ($user instanceof \App\Models\Admin) {
            if ($user->role->name !== 'Super Admin') {
                return response()->json([
                    'message' => 'Unauthorized - Only Super Admin can perform this action.',
                ], 403);
            }
        } elseif ($user instanceof \App\Models\Broker) {
            if ($model->broker_id !== $user->id) {
                return response()->json([
                    'message' => 'Unauthorized - Only the assigned broker can perform this action.',
                ], 403);
            }
        } elseif ($user instanceof \App\Models\User) {
            if ($model->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Unauthorized - Only the owner can perform this action.',
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized - Invalid user type.',
            ], 403);
        }

        return true; 
    }
}
