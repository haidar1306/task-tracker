<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RoomSearchController extends Controller
{
    private const DEST_ID = '-782831'; // Dubai (abhi fixed)

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests'    => 'required|integer|min:1|max:20',
        ]);

        $nights = (int) Carbon::parse($data['check_in'])
            ->diffInDays(Carbon::parse($data['check_out']));

        // Same search dobara aaye to API call nahi hogi (20 requests bachane ke liye)
        $cacheKey = 'hotel_search_' . md5(json_encode($data));

        $hotels = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($data) {
            $response = Http::withHeaders([
                    'x-rapidapi-key'  => config('services.hotel_api.key'),
                    'x-rapidapi-host' => config('services.hotel_api.host'),
                ])
                ->timeout(20)
                ->get('https://' . config('services.hotel_api.host') . '/api/v1/hotels/searchHotels', [
                    'dest_id'        => self::DEST_ID,
                    'search_type'    => 'CITY',
                    'arrival_date'   => $data['check_in'],
                    'departure_date' => $data['check_out'],
                    'adults'         => $data['guests'],
                    'room_qty'       => 1,
                    'currency_code'  => 'INR',
                    'languagecode'   => 'en-us',
                ]);

            return $response->successful()
                ? ($response->json('data.hotels') ?? [])
                : null;
        });

        if ($hotels === null) {
            Cache::forget($cacheKey); // fail hua to cache mat rakho
            return response()->json(['message' => 'Hotel service abhi available nahi hai'], 502);
        }

        $rooms = collect($hotels)->map(function ($h) use ($nights, $data) {
            $p     = $h['property'];
            $total = round($p['priceBreakdown']['grossPrice']['value'] ?? 0);

            return [
                'id'           => $h['hotel_id'],
                'name'         => $p['name'],
                'image'        => $p['photoUrls'][0] ?? null,
                'review_score' => $p['reviewScore'] ?? 0,
                'max_guests'   => (int) $data['guests'],
                'price'        => $nights > 0 ? round($total / $nights) : $total,
                'nights'       => $nights,
                'total_price'  => $total,
                'currency'     => 'INR',
            ];
        })->values();

        return response()->json([
            'count' => $rooms->count(),
            'data'  => $rooms,
        ]);
    }
}