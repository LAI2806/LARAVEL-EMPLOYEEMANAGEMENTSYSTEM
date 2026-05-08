@extends('layouts.app')

@section('content')

<h2 class="mb-4 fw-bold">Profile Settings</h2>

<h5 class="mb-2 ">Update Profile Information</h5>
@include('profile.partials.update-profile-information-form')

<h5 class="mt-4 mb-2">Change Password</h5>
@include('profile.partials.update-password-form')

<h5 class="mt-4 mb-2 text-danger">Delete Account</h5>
@include('profile.partials.delete-user-form')

@endsection