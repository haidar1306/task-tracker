<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Notifications\InquiryNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    /** @test */
    public function a_guest_can_submit_a_contact_inquiry_and_admin_receives_notification()
    {
        Notification::fake();

        $admin = User::factory()->admin()->create();

        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Room booking question',
            'message' => 'I would like to know about the deluxe room and pricing.',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('flash_success', 'Your inquiry has been sent successfully. We will get back to you soon.');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Room booking question',
        ]);

        Notification::assertSentTo($admin, InquiryNotification::class);
    }
}
