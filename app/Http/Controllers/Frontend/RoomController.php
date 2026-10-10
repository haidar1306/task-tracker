<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->validate([
            'check_in' => ['nullable', 'required_with:check_out', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['nullable', 'required_with:check_in', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['nullable', 'required_with:check_in,check_out', 'integer', 'min:1', 'max:20'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price_min'],
            'room_types' => ['sometimes', 'array'],
            'room_types.*' => ['integer', 'distinct', 'exists:room_types,id'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:20'],
            'amenities' => ['sometimes', 'array'],
            'amenities.*' => ['integer', 'distinct', 'exists:amenities,id'],
            'sort' => ['nullable', Rule::in(['recommended', 'price_asc', 'price_desc', 'capacity_desc', 'name_asc'])],
        ]);

        $guestCount = isset($search['guests']) ? (int) $search['guests'] : null;
        $availability = function (Builder $query) use ($guestCount, $search) {
            $query->bookable($guestCount)
                ->availableForStay($search['check_in'] ?? null, $search['check_out'] ?? null);
        };

        $availableRooms = Room::query()->bookable($guestCount)
            ->availableForStay($search['check_in'] ?? null, $search['check_out'] ?? null);
        $availableRoomCount = (clone $availableRooms)->count();

        $roomTypes = RoomType::query()
            ->where('status', true)
            ->whereHas('rooms', $availability)
            ->orderBy('name')
            ->get(['id', 'name']);

        $amenities = Amenity::query()
            ->where('status', true)
            ->whereHas('rooms', $availability)
            ->orderBy('name')
            ->get(['id', 'name']);

        $capacityOptions = RoomType::query()
            ->where('status', true)
            ->whereHas('rooms', $availability)
            ->distinct()
            ->orderBy('capacity')
            ->pluck('capacity');

        $priceBounds = RoomType::query()
            ->where('status', true)
            ->whereHas('rooms', $availability)
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $query = (clone $availableRooms)->with(['roomType', 'amenities']);

        if (!empty($search['room_types'])) {
            $query->whereIn('room_type_id', $search['room_types']);
        }

        if (isset($search['capacity'])) {
            $query->whereHas('roomType', function (Builder $roomTypes) use ($search) {
                $roomTypes->where('capacity', '>=', $search['capacity']);
            });
        }

        if (isset($search['price_min']) || isset($search['price_max'])) {
            $query->whereHas('roomType', function (Builder $roomTypes) use ($search) {
                if (isset($search['price_min'])) {
                    $roomTypes->where('price', '>=', $search['price_min']);
                }

                if (isset($search['price_max'])) {
                    $roomTypes->where('price', '<=', $search['price_max']);
                }
            });
        }

        foreach ($search['amenities'] ?? [] as $amenityId) {
            $query->whereHas('amenities', function (Builder $roomAmenities) use ($amenityId) {
                $roomAmenities->where('amenities.id', $amenityId)
                    ->where('amenities.status', true);
            });
        }

        switch ($search['sort'] ?? 'recommended') {
            case 'price_asc':
                $query->orderBy(RoomType::select('price')->whereColumn('room_types.id', 'rooms.room_type_id'));
                break;
            case 'price_desc':
                $query->orderByDesc(RoomType::select('price')->whereColumn('room_types.id', 'rooms.room_type_id'));
                break;
            case 'capacity_desc':
                $query->orderByDesc(RoomType::select('capacity')->whereColumn('room_types.id', 'rooms.room_type_id'));
                break;
            case 'name_asc':
                $query->orderBy(RoomType::select('name')->whereColumn('room_types.id', 'rooms.room_type_id'));
                break;
            default:
                $query->orderBy('room_type_id')->orderBy('room_number');
                break;
        }

        $rooms = $query->paginate(8)->appends($request->query());
        $nights = isset($search['check_in'], $search['check_out'])
            ? Carbon::parse($search['check_in'])->diffInDays(Carbon::parse($search['check_out']))
            : null;

        return view('frontend.room.index', compact(
            'rooms',
            'search',
            'availableRoomCount',
            'roomTypes',
            'amenities',
            'capacityOptions',
            'priceBounds',
            'nights'
        ));
    }

    public function show(Request $request, Room $room)
    {
        $search = $request->validate([
            'check_in' => ['nullable', 'required_with:check_out', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['nullable', 'required_with:check_in', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['nullable', 'required_with:check_in,check_out', 'integer', 'min:1', 'max:20'],
        ]);

        $room->load(['roomType', 'amenities']);
        $guests = isset($search['guests']) ? (int) $search['guests'] : null;
        $hasStayDates = isset($search['check_in'], $search['check_out']);
        $isBookable = Room::query()
            ->whereKey($room->id)
            ->bookable($guests)
            ->availableForStay($search['check_in'] ?? null, $search['check_out'] ?? null)
            ->exists();

        return view('frontend.room.show', compact('room', 'search', 'isBookable', 'hasStayDates'));
    }
}