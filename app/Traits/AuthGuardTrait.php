<?php

namespace App\Traits;

trait AuthGuardTrait
{
    /**
     * Determine the authenticated user type and return their IDs.
     *
     * @return array
     */
    public function getAuthenticatedIds()
    {
        if (auth()->guard('broker')->check()) {
            $broker = auth()->guard('broker')->user();
            return [
                'broker_id' => $broker->id,
                'user_id' => null,
                'admin_id' => null,
            ];
        } elseif (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
            return [
                'broker_id' => null,
                'user_id' => $user->id,
                'admin_id' => null,
            ];
        } elseif (auth()->guard('admin')->check()) {
            $admin = auth()->guard('admin')->user();
            return [
                'broker_id' => null,
                'user_id' => null,
                'admin_id' => $admin->id,
            ];
        }

        return response()->json([
            'message' => 'Unauthenticated.',
        ], 401);
    }
}
