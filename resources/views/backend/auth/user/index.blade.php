@extends('backend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('User Management')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link :href="route('admin.auth.user.create')" class="btn btn-primary btn-sm float-end"
                icon="fas fa-user-plus" text="Create User" />
        </x-slot>
        <x-slot name="body">
            <livewire:backend.users-table />
        </x-slot>
    </x-backend.card>
@endsection