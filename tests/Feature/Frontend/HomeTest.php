<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Tests\TestCase;

/**
 * Class HomeTest.
 */
class HomeTest extends TestCase
{
    /** @test */
    public function the_home_page_exists()
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('frontend-shell')
            ->assertSee('hotel-navbar');

        $this->assertSame(1, substr_count($response->getContent(), '<body '));
        $this->assertStringContainsString(
            'class="frontend-shell frontend-dark-hero home-page',
            $response->getContent()
        );
    }

    /** @test */
    public function nested_frontend_pages_use_the_shared_navbar_layout()
    {
        $this->get(route('frontend.pages.terms'))
            ->assertOk()
            ->assertSee('frontend-shell')
            ->assertSee('hotel-navbar');

        $user = User::factory()->user()->create();
        $guest = Guest::create([
            'first_name' => 'Frontend',
            'last_name' => 'Guest',
            'email' => $user->email,
            'phone' => '1234567890',
        ]);
        $roomType = RoomType::create([
            'name' => 'Navbar Test Room',
            'capacity' => 2,
            'price' => 2500,
            'status' => true,
        ]);
        $room = Room::create([
            'room_number' => 'NAV-1',
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);
        $reservation = Booking::create([
            'booking_no' => 'NAVBAR-TEST-' . uniqid(),
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => today()->addDay()->toDateString(),
            'check_out' => today()->addDays(2)->toDateString(),
            'adults' => 1,
            'children' => 0,
            'total_amount' => 2500,
            'booking_status' => 'Pending',
            'payment_status' => 'Pending',
            'status' => true,
        ]);

        $this->actingAs($user)
            ->get(route('frontend.reservation.show', $reservation->id))
            ->assertOk()
            ->assertSee('frontend-shell')
            ->assertSee('hotel-navbar');
    }
}
