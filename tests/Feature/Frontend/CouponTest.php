<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Guest;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CouponTest extends TestCase
{
    /** @test */
    public function percentage_coupon_calculates_from_unpaid_balance_and_can_be_reapplied_without_stacking()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);

        $invoice = $this->createInvoiceFor($user, [
            'total_amount' => 1200,
            'discount' => 100,
            'paid_amount' => 200,
        ]);
        $coupon = $this->createCoupon([
            'code' => 'SAVE10',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'minimum_amount' => 500,
            'maximum_discount' => 150,
        ]);

        $request = ['invoice_id' => $invoice->id, 'coupon_code' => ' save10 '];

        $this->postJson(route('frontend.coupon.apply'), $request)
            ->assertOk()
            ->assertJson([
                'status' => true,
                'discount' => 90,
                'final_amount' => 810,
            ]);

        $this->postJson(route('frontend.coupon.apply'), $request)
            ->assertOk()
            ->assertJson([
                'status' => true,
                'discount' => 90,
                'final_amount' => 810,
            ]);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'coupon_id' => $coupon->id,
            'coupon_discount' => 90,
            'discount' => 190,
        ]);
    }

    /** @test */
    public function coupon_endpoint_rejects_an_invoice_owned_by_another_customer()
    {
        $this->actingAs(User::factory()->user()->create());
        $invoiceOwner = User::factory()->user()->create();
        $invoice = $this->createInvoiceFor($invoiceOwner);
        $this->createCoupon(['code' => 'OWNER10']);

        $this->postJson(route('frontend.coupon.apply'), [
            'invoice_id' => $invoice->id,
            'coupon_code' => 'OWNER10',
        ])->assertForbidden();

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'discount' => 0,
            'coupon_id' => null,
        ]);
    }

    /** @test */
    public function invalid_coupon_does_not_change_invoice_discounts()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);
        $invoice = $this->createInvoiceFor($user, ['discount' => 75]);
        $this->createCoupon([
            'code' => 'OLD10',
            'expires_at' => now()->subDay(),
        ]);

        $this->postJson(route('frontend.coupon.apply'), [
            'invoice_id' => $invoice->id,
            'coupon_code' => 'OLD10',
        ])->assertOk()
            ->assertJsonPath('status', false);

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'discount' => 75,
            'coupon_discount' => 0,
            'coupon_id' => null,
        ]);
    }

    /** @test */
    public function coupon_schedule_uses_the_admin_datetime_local_timezone()
    {
        $startedCoupon = $this->createCoupon([
            'code' => 'STARTED-LOCAL',
            'starts_at' => now('Asia/Kolkata')->subMinutes(2)->format('Y-m-d H:i:s'),
            'expires_at' => now('Asia/Kolkata')->addDay()->format('Y-m-d H:i:s'),
        ]);
        $futureCoupon = $this->createCoupon([
            'code' => 'FUTURE-LOCAL',
            'starts_at' => now('Asia/Kolkata')->addMinutes(2)->format('Y-m-d H:i:s'),
        ]);

        $this->assertNull($startedCoupon->invalidReason());
        $this->assertSame('This coupon is not active yet.', $futureCoupon->invalidReason());
    }

    /** @test */
    public function customer_can_retry_coupon_codes_without_hitting_a_ten_attempt_limit()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);
        $invoice = $this->createInvoiceFor($user);
        $coupon = $this->createCoupon(['code' => 'RETRY10']);

        for ($attempt = 0; $attempt < 11; $attempt++) {
            $this->postJson(route('frontend.coupon.apply'), [
                'invoice_id' => $invoice->id,
                'coupon_code' => $coupon->code,
            ])->assertOk()->assertJsonPath('status', true);
        }
    }

    /** @test */
    public function coupon_usage_is_counted_once_after_the_first_successful_payment()
    {
        Notification::fake();
        $user = User::factory()->user()->create();
        $this->actingAs($user);
        $invoice = $this->createInvoiceFor($user);
        $coupon = $this->createCoupon([
            'code' => 'ONCE10',
            'discount_type' => 'fixed',
            'discount_value' => 100,
            'usage_limit' => 1,
        ]);

        $this->postJson(route('frontend.coupon.apply'), [
            'invoice_id' => $invoice->id,
            'coupon_code' => $coupon->code,
        ])->assertOk()->assertJsonPath('final_amount', 1100);

        $paymentData = [
            'amount' => 100,
            'payment_method' => 'UPI',
        ];

        $this->post(route('frontend.payment.store', $invoice->id), $paymentData)
            ->assertRedirect(route('frontend.invoice.show', $invoice->id));
        $this->assertSame(1, $coupon->fresh()->used_count);

        $this->post(route('frontend.payment.store', $invoice->id), $paymentData)
            ->assertRedirect(route('frontend.invoice.show', $invoice->id));
        $this->assertSame(1, $coupon->fresh()->used_count);

        $anotherCustomer = User::factory()->user()->create();
        $anotherInvoice = $this->createInvoiceFor($anotherCustomer);
        $this->actingAs($anotherCustomer);

        $this->postJson(route('frontend.coupon.apply'), [
            'invoice_id' => $anotherInvoice->id,
            'coupon_code' => $coupon->code,
        ])->assertOk()
            ->assertJsonPath('status', false)
            ->assertJsonPath('message', 'This coupon usage limit has been reached.');
    }

    /** @test */
    public function customer_cannot_create_a_payment_order_for_another_customers_invoice()
    {
        $this->actingAs(User::factory()->user()->create());
        $invoiceOwner = User::factory()->user()->create();
        $invoice = $this->createInvoiceFor($invoiceOwner);

        $this->postJson(route('frontend.payment.create-order'), [
            'invoice_id' => $invoice->id,
            'amount' => 100,
        ])->assertForbidden();
    }

    /** @test */
    public function full_discount_coupon_completes_the_invoice_without_requesting_a_zero_value_payment()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);
        $invoice = $this->createInvoiceFor($user);
        $coupon = $this->createCoupon([
            'code' => 'FULLCOVER',
            'discount_type' => 'percentage',
            'discount_value' => 100,
            'usage_limit' => 1,
        ]);

        $this->postJson(route('frontend.coupon.apply'), [
            'invoice_id' => $invoice->id,
            'coupon_code' => $coupon->code,
        ])->assertOk()
            ->assertJsonPath('fully_discounted', true)
            ->assertJsonPath('final_amount', 0)
            ->assertJsonPath('redirect', route('frontend.invoice.show', $invoice->id));

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'discount' => 1200,
            'payment_status' => 'Paid',
            'coupon_redeemed_at' => $invoice->fresh()->coupon_redeemed_at,
        ]);
        $this->assertSame(1, $coupon->fresh()->used_count);
        $this->assertDatabaseHas('bookings', [
            'id' => $invoice->booking_id,
            'payment_status' => 'Paid',
            'booking_status' => 'Confirmed',
        ]);
    }

    private function createInvoiceFor(User $user, array $overrides = []): Invoice
    {
        $name = explode(' ', $user->name, 2);
        $guest = Guest::create([
            'first_name' => $name[0],
            'last_name' => $name[1] ?? null,
            'email' => $user->email,
            'phone' => '1234567890',
        ]);
        $roomType = RoomType::create([
            'name' => 'Coupon Test ' . uniqid(),
            'capacity' => 2,
            'price' => 1000,
            'status' => true,
        ]);
        $room = Room::create([
            'room_number' => 'CP-' . uniqid(),
            'room_type_id' => $roomType->id,
            'floor' => 1,
            'status' => 'available',
        ]);
        $booking = Booking::create([
            'booking_no' => 'CP-' . uniqid(),
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => today()->addDay()->toDateString(),
            'check_out' => today()->addDays(2)->toDateString(),
            'adults' => 1,
            'children' => 0,
            'total_amount' => 1200,
            'booking_status' => 'Pending',
            'payment_status' => 'Pending',
            'status' => true,
        ]);

        return Invoice::create(array_merge([
            'invoice_no' => 'INV-CP-' . uniqid(),
            'booking_id' => $booking->id,
            'room_charge' => 1200,
            'extra_charge' => 0,
            'tax' => 0,
            'discount' => 0,
            'total_amount' => 1200,
            'payment_status' => 'Pending',
            'paid_amount' => 0,
            'status' => true,
        ], $overrides));
    }

    private function createCoupon(array $overrides = []): Coupon
    {
        return Coupon::create(array_merge([
            'name' => $overrides['code'] ?? 'TEST-' . uniqid(),
            'code' => 'TEST-' . uniqid(),
            'discount_type' => 'fixed',
            'discount_value' => 50,
            'minimum_amount' => 0,
            'maximum_discount' => null,
            'starts_at' => null,
            'expires_at' => null,
            'usage_limit' => null,
            'used_count' => 0,
            'status' => true,
            'description' => null,
        ], $overrides));
    }
}