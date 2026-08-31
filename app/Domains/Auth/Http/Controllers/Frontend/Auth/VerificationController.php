<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Email verification has been disabled.
 * All old verification URLs now redirect to the user dashboard.
 */
class VerificationController
{
    /**
     * Redirect the verification notice page to dashboard.
     */
    public function show(Request $request): RedirectResponse
    {
        return $this->dashboardRedirect();
    }

    /**
     * Redirect old email-verification links to dashboard.
     */
    public function verify(Request $request, $id = null, $hash = null): RedirectResponse
    {
        return $this->dashboardRedirect();
    }

    /**
     * Redirect old resend-verification requests to dashboard.
     */
    public function resend(Request $request): RedirectResponse
    {
        return $this->dashboardRedirect();
    }

    /**
     * Supports newer Laravel verification resend route names.
     */
    public function send(Request $request): RedirectResponse
    {
        return $this->dashboardRedirect();
    }

    /**
     * Shared dashboard redirect.
     */
    private function dashboardRedirect(): RedirectResponse
    {
        return redirect()->route('frontend.user.dashboard');
    }
}