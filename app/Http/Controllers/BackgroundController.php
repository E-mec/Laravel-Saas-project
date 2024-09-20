<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Feature;
use App\Models\UsedFeature;
use Illuminate\Http\Request;
use App\Services\RemoveBgService;
use App\Http\Resources\FeatureResource;

class BackgroundController extends Controller
{
    protected $removeBgService;

    public ?Feature $feature = null;


    public function __construct(RemoveBgService $removeBgService)
    {
        $this->removeBgService = $removeBgService;

        $this->feature = Feature::where('route_name', 'feature3.index')
                            ->where('active', true)
                            ->firstOrFail();
    }

    public function index()
        {
            // dd("Showing");
        return Inertia::render('Feature3/Index', [
            'feature' => new FeatureResource($this->feature),
            'answer' => session('answer')
        ]);
    }

    public function removeBackground(Request $request)
    {
        $user = $request->user();

        if ($user->available_credits < $this->feature->required_credits) {
            return back();
        }

        $request->validate([
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->getRealPath();
        $imageUrl = $this->removeBgService->removeBackground($imagePath);
        $user->decreaseCredits($this->feature->required_credits);

        UsedFeature::create([
            'feature_id' => $this->feature->id,
            'user_id' => $user->id,
            'credits' => $this->feature->required_credits,
            'data' => $imageUrl
        ]);


        return response()->json(['image_url' => $imageUrl]);
    }

}
