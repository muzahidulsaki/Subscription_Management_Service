<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    //
    public function getPackages()
    {
        $packages = Package::select('id', 'name', 'price', 'duration_days', 'type')->get();

        return response()->json([
            'status' => 'success',
            'data' => $packages
        ], 200);
    }

    /**
     * Subscribe a user to a package
     */
    public function subscribe(Request $request)
    {
        // Validation
        $request->validate([
            'user_id' => 'required|integer',
            'package_id' => 'required|exists:packages,id',
        ]);

        $userId = $request->user_id;
        $package = Package::find($request->package_id);

        // Trial Check
        if ($package->type === 'trial') {
            $hasUsedTrial = Subscription::where('user_id', $userId)
                ->whereHas('package', function ($query) {
                    $query->where('type', 'trial');
                })->exists();

            if ($hasUsedTrial) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already used your Trial period.'
                ], 403);
            }
        }

        // Overlap Check 
        $activeSubscription = Subscription::where('user_id', $userId)
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if ($activeSubscription) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have an active subscription.',
                'expires_at' => $activeSubscription->ends_at
            ], 403);
        }

        // Create Subscription
        $subscription = Subscription::create([
            'user_id' => $userId,
            'package_id' => $package->id,
            'type' => $package->type, // trial or monthly
            'started_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addDays($package->duration_days),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription activated successfully!',
            'data' => $subscription
        ], 201);
    }

    /**
     * Get current subscription status for a user
     */
    public function getStatus($user_id)
    {
        $activeSubscription = Subscription::with('package')
            ->where('user_id', $user_id)
            ->where('ends_at', '>', Carbon::now())
            ->orderBy('ends_at', 'desc')
            ->first();

        if ($activeSubscription) {
            return response()->json([
                'status' => 'active',
                'package' => $activeSubscription->package->name,
                'type' => $activeSubscription->type,
                'ends_at' => $activeSubscription->ends_at,
                'days_left' => Carbon::now()->diffInDays($activeSubscription->ends_at)
            ]);
        }

        return response()->json([
            'status' => 'inactive',
            'message' => 'No active subscription found.'
        ]);
    }

    /**
     * Get full subscription history for a user
     */
    
    public function getHistory($user_id)
    {
        $history = Subscription::with('package')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $history
        ]);
    }
}
