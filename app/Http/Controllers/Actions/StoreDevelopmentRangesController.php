<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Http\Requests\DevRangesCreateRequest;
use App\Models\AgeRange;
use App\Models\DevRange;

class StoreDevelopmentRangesController extends Controller
{
    public function __invoke(DevRangesCreateRequest $request)
    {
        DevRange::query()->delete();
        AgeRange::query()->delete();

        $ageRanges = collect($request->get('ageRanges'));

        $ageRanges->each(function (array $ageRange) {
            $createdRange = AgeRange::create([
                'min_age' => $ageRange['min_age'],
                'max_age' => $ageRange['max_age'],
            ]);

            $ranges = collect($ageRange['ranges']);

            $ranges->each(function (array $range) use ($createdRange) {
                $createdRange->ranges()->create([
                    'min_rating' => $range['min_rating'],
                    'max_rating' => $range['max_rating'],
                    'min_dev' => $range['min_dev'],
                    'max_dev' => $range['max_dev'],
                ]);
            });
        });

        return redirect(route('admin.development.show'));
    }
}
