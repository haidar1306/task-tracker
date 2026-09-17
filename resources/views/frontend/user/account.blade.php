@extends('frontend.layouts.app')

@section('title', __('My Account'))

@push('after-styles')
<style>
    .account-hero {
        background: #1c1712;
        padding: 70px 24px 56px;
        text-align: center;
    }

    .account-hero span {
        display: block;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        letter-spacing: 2px;
        color: #d9c4a5;
        margin-bottom: 16px;
    }

    .account-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 600;
        color: #fdfbf7;
        margin: 0;
    }

    .account-wrap {
        max-width: 900px;
        margin: 0 auto;
        padding: 60px 24px 100px;
    }

    /* Card container */
    .account-wrap .card,
    .account-wrap .card-body {
        border: 1px solid #e7ddca !important;
        border-radius: 4px !important;
        box-shadow: none !important;
    }

    .account-wrap .card-header {
        display: none;
    }

    /* Tabs */
    .account-wrap .nav-tabs {
        border-bottom: 1px solid #e7ddca;
        gap: 6px;
        padding: 0 8px;
        margin-bottom: 0;
    }

    .account-wrap .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        border-radius: 0;
        font-family: 'Jost', sans-serif;
        font-size: 13px;
        letter-spacing: .5px;
        color: #8a7f6f;
        padding: 16px 18px;
        transition: color .2s ease, border-color .2s ease;
    }

    .account-wrap .nav-tabs .nav-link:hover {
        color: #2b2621;
    }

    .account-wrap .nav-tabs .nav-link.active {
        color: #a9825c;
        background: transparent;
        border-bottom-color: #a9825c;
    }

    .account-wrap .tab-content {
        padding: 34px 30px;
        background: #fffdfa;
    }

    /* Form fields inside tabs, in case they use bootstrap defaults */
    .account-wrap .form-control {
        border: 1px solid #e7ddca;
        border-radius: 3px;
        font-family: 'Jost', sans-serif;
        padding: 11px 14px;
    }

    .account-wrap .form-control:focus {
        border-color: #a9825c;
        box-shadow: none;
    }

    .account-wrap label {
        font-family: 'Jost', sans-serif;
        font-size: 12px;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: #8a7f6f;
    }

    .account-wrap .btn-primary,
    .account-wrap button[type="submit"] {
        background: #a9825c;
        border-color: #a9825c;
        font-family: 'Jost', sans-serif;
        font-size: 14px;
        letter-spacing: .5px;
        padding: 11px 26px;
        border-radius: 3px;
    }

    .account-wrap .btn-primary:hover,
    .account-wrap button[type="submit"]:hover {
        background: #8f6c48;
        border-color: #8f6c48;
    }

    @media (max-width: 576px) {
        .account-wrap .nav-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .account-wrap .nav-tabs .nav-link {
            white-space: nowrap;
        }

        .account-wrap .tab-content {
            padding: 26px 18px;
        }
    }
</style>
@endpush

@section('content')

    <div class="account-hero">
        <span>Your Account</span>
        <h1>My Account</h1>
    </div>

    <div class="account-wrap">

        <x-frontend.card>
            <x-slot name="body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <x-utils.link
                            :text="__('My Profile')"
                            class="nav-link active"
                            id="my-profile-tab"
                            data-toggle="pill"
                            href="#my-profile"
                            role="tab"
                            aria-controls="my-profile"
                            aria-selected="true" />

                        <x-utils.link
                            :text="__('Edit Information')"
                            class="nav-link"
                            id="information-tab"
                            data-toggle="pill"
                            href="#information"
                            role="tab"
                            aria-controls="information"
                            aria-selected="false"/>

                        @if (! $logged_in_user->isSocial())
                            <x-utils.link
                                :text="__('Password')"
                                class="nav-link"
                                id="password-tab"
                                data-toggle="pill"
                                href="#password"
                                role="tab"
                                aria-controls="password"
                                aria-selected="false" />
                        @endif

                        <x-utils.link
                            :text="__('Two Factor Authentication')"
                            class="nav-link"
                            id="two-factor-authentication-tab"
                            data-toggle="pill"
                            href="#two-factor-authentication"
                            role="tab"
                            aria-controls="two-factor-authentication"
                            aria-selected="false"/>
                    </div>
                </nav>

                <div class="tab-content" id="my-profile-tabsContent">
                    <div class="tab-pane fade pt-3 show active" id="my-profile" role="tabpanel" aria-labelledby="my-profile-tab">
                        @include('frontend.user.account.tabs.profile')
                    </div><!--tab-profile-->

                    <div class="tab-pane fade pt-3" id="information" role="tabpanel" aria-labelledby="information-tab">
                        @include('frontend.user.account.tabs.information')
                    </div><!--tab-information-->

                    @if (! $logged_in_user->isSocial())
                        <div class="tab-pane fade pt-3" id="password" role="tabpanel" aria-labelledby="password-tab">
                            @include('frontend.user.account.tabs.password')
                        </div><!--tab-password-->
                    @endif

                    <div class="tab-pane fade pt-3" id="two-factor-authentication" role="tabpanel" aria-labelledby="two-factor-authentication-tab">
                        @include('frontend.user.account.tabs.two-factor-authentication')
                    </div><!--tab-information-->
                </div><!--tab-content-->
            </x-slot>
        </x-frontend.card>

    </div>

@endsection