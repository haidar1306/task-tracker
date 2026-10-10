<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Booking;
use App\Models\Booking1;
use App\Models\Amenity;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RoomSearchTest extends TestCase
{
    /** @test */
    public function search_excludes_overlapping_bookings_and_rooms_that_cannot_fit_the_guests()
    {
        $this->actingAs(User::factory()->user()->create());

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(13);

        $overlappingRoom = $this->createRoom('101', 2);
        $backToBackRoom = $this->createRoom('102', 2);
        $smallRoom = $this->createRoom('103', 1);
        $maintenanceRoom = $this->createRoom('105', 2, 'maintenance');
        $inactiveTypeRoom = $this->createRoom('106', 2, 'available', false);

        $this->createBooking($overlappingRoom, $checkIn->copy()->subDay(), $checkOut->copy()->addDay());
        $this->createBooking($backToBackRoom, $checkOut->copy(), $checkOut->copy()->addDays(2));

        $response = $this->get(route('frontend.room.index', [
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'guests' => 2,
        ]));

        $response->assertOk()->assertViewHas('rooms', function ($rooms) use (
            $backToBackRoom,
            $overlappingRoom,
            $smallRoom,
            $maintenanceRoom,
            $inactiveTypeRoom
        ) {
            return $rooms->contains('id', $backToBackRoom->id)
                && !$rooms->contains('id', $overlappingRoom->id)
                && !$rooms->contains('id', $smallRoom->id)
                && !$rooms->contains('id', $maintenanceRoom->id)
                && !$rooms->contains('id', $inactiveTypeRoom->id);
        });
    }

    /** @test */
    public function search_rejects_past_check_in_and_checkout_before_check_in()
    {
        $this->actingAs(User::factory()->user()->create());

        $this->get(route('frontend.room.index', [
            'check_in' => today()->subDay()->toDateString(),
            'check_out' => today()->addDay()->toDateString(),
            'guests' => 1,
        ]))->assertSessionHasErrors('check_in');

        $this->get(route('frontend.room.index', [
            'check_in' => today()->addDays(2)->toDateString(),
            'check_out' => today()->addDay()->toDateString(),
            'guests' => 1,
        ]))->assertSessionHasErrors('check_out');
    }

    /** @test */
    public function undated_room_browsing_does_not_claim_stay_availability_and_prices_match_filter_bounds()
    {
        $this->actingAs(User::factory()->user()->create());
        $room = $this->createRoom('105', 2, 'available', true, 50000);

        $this->get(route('frontend.room.index'))
            ->assertOk()
            ->assertSee('room-search-results')
            ->assertSee('Browse Rooms')
            ->assertSee('dates not checked')
            ->assertSee('Availability not checked')
            ->assertSee('Select dates to check availability')
            ->assertDontSee('Available for these dates')
            ->assertSee('₹50,000.00', false)
            ->assertSee('placeholder="50,000"', false)
            ->assertViewHas('priceBounds', function ($bounds) {
                return (float) $bounds->min_price === 50000.0
                    && (float) $bounds->max_price === 50000.0;
            })
            ->assertViewHas('rooms', function ($rooms) use ($room) {
                return $rooms->contains('id', $room->id);
            });
    }

    /** @test */
    public function known_hotel_logo_upload_is_not_used_as_a_room_photo()
    {
        $roomType = RoomType::create([
            'name' => 'Logo image test',
            'capacity' => 2,
            'price' => 50000,
            'status' => true,
            'image' => 'https://res.cloudinary.com/example/image/upload/room-types/w7cqw0gwll5hq6jypt5x.png',
        ]);

        $this->assertSame($roomType->image, $roomType->image_url);
        $this->assertNull($roomType->room_photo_url);
    }

    /** @test */
    public function room_details_show_date_unverified_state_and_choose_dates_action()
    {
        $this->actingAs(User::factory()->user()->create());
        $room = $this->createRoom('106', 2);
        $room->roomType->update([
            'image' => 'https://res.cloudinary.com/example/image/upload/room-types/w7cqw0gwll5hq6jypt5x.png',
        ]);

        $this->get(route('frontend.room.show', $room->id))
            ->assertOk()
            ->assertSee('frontend-shell')
            ->assertSee('Select dates to check availability')
            ->assertSee('Choose Dates')
            ->assertSee('Room photograph not available')
            ->assertDontSee('Available for selected dates');
    }

    /** @test */
    public function price_minimum_cannot_exceed_price_maximum()
    {
        $this->actingAs(User::factory()->user()->create());

        $this->get(route('frontend.room.index', [
            'price_min' => 60000,
            'price_max' => 50000,
        ]))->assertSessionHasErrors('price_max');
    }

    /** @test */
    public function room_filters_combine_price_type_capacity_and_amenities()
    {
        $this->actingAs(User::factory()->user()->create());

        $matchingRoom = $this->createRoom('501', 4, 'available', true, 3200);
        $wrongTypeRoom = $this->createRoom('502', 4, 'available', true, 3200);
        $lowPriceRoom = $this->createRoom('503', 4, 'available', true, 900);
        $lowCapacityRoom = $this->createRoom('504', 2, 'available', true, 3200);
        $selectedType = $matchingRoom->roomType;
        $amenity = Amenity::create(['name' => 'Search Wi-Fi', 'status' => true]);
        $matchingRoom->amenities()->attach($amenity->id);
        $wrongTypeRoom->amenities()->attach($amenity->id);

        $response = $this->get(route('frontend.room.index', [
            'check_in' => today()->addDays(10)->toDateString(),
            'check_out' => today()->addDays(12)->toDateString(),
            'guests' => 1,
            'price_min' => 2000,
            'price_max' => 4000,
            'room_types' => [$selectedType->id],
            'capacity' => 3,
            'amenities' => [$amenity->id],
        ]));

        $response->assertOk()->assertViewHas('rooms', function ($rooms) use ($matchingRoom, $wrongTypeRoom, $lowPriceRoom, $lowCapacityRoom) {
            return $rooms->count() === 1
                && $rooms->first()->id === $matchingRoom->id
            && !$rooms->contains('id', $wrongTypeRoom->id)
                && !$rooms->contains('id', $lowPriceRoom->id)
                && !$rooms->contains('id', $lowCapacityRoom->id);
        });
    }

    /** @test */
    public function price_sort_uses_room_type_prices_and_clear_filter_link_keeps_stay()
    {
        $this->actingAs(User::factory()->user()->create());

        $expensive = $this->createRoom('601', 2, 'available', true, 4000);
        $affordable = $this->createRoom('602', 2, 'available', true, 1200);
        $search = [
            'check_in' => today()->addDays(10)->toDateString(),
            'check_out' => today()->addDays(12)->toDateString(),
            'guests' => 2,
            'price_min' => 1000,
            'sort' => 'price_asc',
        ];

        $response = $this->get(route('frontend.room.index', $search));

        $clearUrl = htmlspecialchars(route('frontend.room.index', [
            'check_in' => $search['check_in'],
            'check_out' => $search['check_out'],
            'guests' => $search['guests'],
        ]), ENT_QUOTES, 'UTF-8');

        $response->assertOk()
            ->assertSee('check_in=' . $search['check_in'], false)
            ->assertSee('class="text-action" href="' . $clearUrl . '"', false)
            ->assertViewHas('rooms', function ($rooms) use ($affordable, $expensive) {
                return $rooms->first()->id === $affordable->id
                    && $rooms->last()->id === $expensive->id;
            });
    }

    /** @test */
    public function unmatched_filters_offer_to_clear_filters_without_losing_the_stay()
    {
        $this->actingAs(User::factory()->user()->create());
        $this->createRoom('603', 2, 'available', true, 1800);
        $search = [
            'check_in' => today()->addDays(10)->toDateString(),
            'check_out' => today()->addDays(12)->toDateString(),
            'guests' => 2,
            'price_min' => 99999,
        ];

        $this->get(route('frontend.room.index', $search))
            ->assertOk()
            ->assertSee('No rooms match these filters.')
            ->assertSee('Clear filters')
            ->assertSee('check_in=' . $search['check_in'], false);
    }

    /** @test */
    public function pagination_preserves_dates_guest_count_filters_and_sort()
    {
        $this->actingAs(User::factory()->user()->create());

        for ($index = 1; $index <= 9; $index++) {
            $this->createRoom('70' . $index, 2, 'available', true, 1500 + $index);
        }

        $search = [
            'check_in' => today()->addDays(10)->toDateString(),
            'check_out' => today()->addDays(12)->toDateString(),
            'guests' => 2,
            'price_min' => 1000,
            'sort' => 'price_desc',
        ];

        $this->get(route('frontend.room.index', $search))
            ->assertOk()
            ->assertViewHas('rooms', function ($rooms) use ($search) {
                return $rooms->hasPages()
                    && strpos($rooms->url(2), 'check_in=' . $search['check_in']) !== false
                    && strpos($rooms->url(2), 'price_min=1000') !== false
                    && strpos($rooms->url(2), 'sort=price_desc') !== false;
            });
    }

    /** @test */
    public function search_dates_and_guest_count_reach_the_booking_form()
    {
        $this->actingAs(User::factory()->user()->create());

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $room = $this->createRoom('104', 3);
        $search = [
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'guests' => 3,
        ];

        $this->get(route('frontend.room.show', array_merge(['room' => $room->id], $search)))
            ->assertOk()
            ->assertSee('check_in=' . $checkIn->toDateString(), false)
            ->assertSee('check_out=' . $checkOut->toDateString(), false)
            ->assertSee('guests=3', false);

        $this->get(route('frontend.bookings.create', array_merge(['room' => $room->id], $search)))
            ->assertOk()
            ->assertSee('value="' . $checkIn->toDateString() . '"', false)
            ->assertSee('value="' . $checkOut->toDateString() . '"', false)
            ->assertSee('value="3"', false);
    }

    /** @test */
    public function choose_dates_from_undated_results_opens_the_existing_booking_form()
    {
        $this->actingAs(User::factory()->user()->create());
        $room = $this->createRoom('107', 3);
        $guests = 2;

        $results = $this->get(route('frontend.room.index', ['guests' => $guests]));
        $bookingUrl = htmlspecialchars(route('frontend.bookings.create', [
            'room' => $room->id,
            'guests' => $guests,
        ]), ENT_QUOTES, 'UTF-8');

        $results->assertOk()
            ->assertSee('class="room-action-primary" href="' . $bookingUrl . '">Choose dates</a>', false);

        $this->get(route('frontend.bookings.create', [
            'room' => $room->id,
            'guests' => $guests,
        ]))
            ->assertOk()
            ->assertSee('Room ' . $room->room_number)
            ->assertSee('name="check_in"', false)
            ->assertSee('name="check_out"', false)
            ->assertSee('value="2"', false);
    }

    /** @test */
    public function cancelled_bookings_do_not_block_room_search()
    {
        $this->actingAs(User::factory()->user()->create());

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $room = $this->createRoom('201', 2);

        $this->createBooking($room, $checkIn->copy(), $checkOut->copy(), 'Cancelled');
        $this->createBooking($room, $checkIn->copy(), $checkOut->copy(), 'Checked Out');

        $this->get(route('frontend.room.index', [
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'guests' => 2,
        ]))->assertViewHas('rooms', function ($rooms) use ($room) {
            return $rooms->contains('id', $room->id);
        });
    }

    /** @test */
    public function booking_submission_rechecks_availability_and_rejects_overlaps()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $room = $this->createRoom('301', 2);
        $this->createBooking($room, $checkIn->copy(), $checkOut->copy());

        $this->post(route('frontend.bookings.store'), [
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => 2,
            'children' => 0,
        ])->assertSessionHasErrors('room_id');
    }

    /** @test */
    public function booking_total_uses_room_price_and_validated_nights()
    {
        $this->actingAs(User::factory()->user()->create());

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $room = $this->createRoom('302', 2);

        $this->post(route('frontend.bookings.store'), [
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => 2,
            'children' => 0,
            'total_amount' => 1,
        ])->assertRedirect(route('frontend.room.index'));

        $booking = Booking1::where('room_id', $room->id)->firstOrFail();
        $this->assertSame(3000.0, (float) $booking->total_amount);
    }

    /** @test */
    public function booking_submission_rejects_a_guest_count_above_room_capacity()
    {
        $this->actingAs(User::factory()->user()->create());

        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $room = $this->createRoom('303', 2);

        $this->post(route('frontend.bookings.store'), [
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => 2,
            'children' => 1,
        ])->assertSessionHasErrors('room_id');
    }

    /** @test */
    public function admin_booking_service_rejects_an_overlapping_booking()
    {
        $room = $this->createRoom('401', 2);
        $checkIn = today()->addDays(10);
        $checkOut = today()->addDays(12);
        $this->createBooking($room, $checkIn->copy(), $checkOut->copy());

        $guest = Guest::create([
            'first_name' => 'Admin',
            'last_name' => 'Booking',
            'email' => 'admin-booking@example.com',
            'phone' => '1234567890',
        ]);

        try {
            resolve(BookingService::class)->store([
                'guest_id' => $guest->id,
                'room_id' => $room->id,
                'check_in' => $checkIn->toDateString(),
                'check_out' => $checkOut->toDateString(),
                'adults' => 2,
                'children' => 0,
                'total_amount' => 3000,
                'booking_status' => 'Pending',
                'payment_status' => 'Pending',
                'status' => true,
            ]);

            $this->fail('Expected overlapping admin booking to be rejected.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('room_id', $exception->errors());
        }
    }

    /** @test */
    public function an_admin_can_edit_a_booking_without_conflicting_with_itself()
    {
        $room = $this->createRoom('402', 2);
        $originalCheckIn = today()->addDays(10);
        $originalCheckOut = today()->addDays(12);
        $booking = $this->createBooking($room, $originalCheckIn->copy(), $originalCheckOut->copy());

        $resolveCheckIn = $originalCheckIn->copy()->addDay();
        $resolveCheckOut = $originalCheckOut->copy()->addDay();

        resolve(BookingService::class)->update(Booking::findOrFail($booking->id), [
            'guest_id' => $booking->guest_id,
            'room_id' => $room->id,
            'check_in' => $resolveCheckIn->toDateString(),
            'check_out' => $resolveCheckOut->toDateString(),
            'adults' => 2,
            'children' => 0,
            'total_amount' => 3000,
            'booking_status' => 'Confirmed',
            'payment_status' => 'Pending',
            'status' => true,
        ]);

        $this->assertSame(
            $resolveCheckIn->toDateString(),
            Carbon::parse($booking->fresh()->check_in)->toDateString()
        );
    }

    private function createRoom(
        string $number,
        int $capacity,
        string $status = 'available',
        bool $roomTypeActive = true,
        int $price = 1500
    ): Room
    {
        $roomType = RoomType::create([
            'name' => 'Search Type ' . $number,
            'capacity' => $capacity,
            'price' => $price,
            'status' => $roomTypeActive,
        ]);

        return Room::create([
            'room_number' => $number,
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => $status,
        ]);
    }

    private function createBooking(Room $room, Carbon $checkIn, Carbon $checkOut, string $status = 'Confirmed'): Booking1
    {
        $guest = Guest::create([
            'first_name' => 'Search Guest',
            'last_name' => 'Test',
            'email' => uniqid('guest', true) . '@example.com',
            'phone' => '1234567890',
        ]);

        return Booking1::create([
            'booking_no' => uniqid('BK-'),
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => 2,
            'children' => 0,
            'total_amount' => 3000,
            'booking_status' => $status,
            'payment_status' => 'Pending',
            'status' => true,
        ]);
    }
}