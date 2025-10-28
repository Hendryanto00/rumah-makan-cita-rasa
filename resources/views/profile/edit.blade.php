@extends('layouts.app')

@section('content')
    {{-- Background Section --}}
    <div class="min-h-screen bg-gradient-to-r from-orange-100 via-red-50 to-yellow-100 py-8 md:py-16 px-4 sm:px-6 flex justify-center">
        <div class="w-full max-w-3xl space-y-6 md:space-y-8">
            {{-- Update Profile Info --}}
            <div class="p-4 md:p-6 bg-white border border-orange-100 shadow-lg rounded-xl md:rounded-2xl hover:shadow-xl transition duration-300">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="p-4 md:p-6 bg-white border border-orange-100 shadow-lg rounded-xl md:rounded-2xl hover:shadow-xl transition duration-300">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div class="p-4 md:p-6 bg-white border border-red-100 shadow-lg rounded-xl md:rounded-2xl hover:shadow-xl transition duration-300">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
