<!-- resources/views/volunteers/profile.blade.php -->
@extends('layouts.app')

@section('content')
    <div>
        <h1>Your Profile</h1>
        <form method="POST" action="{{ route('volunteers.profile.update') }}">
            @csrf
            @method('PUT')

            <!-- First Name -->
            <div>
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
            </div>

            <!-- Bio -->
            <div>
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio">{{ old('bio', auth()->user()->bio) }}</textarea>
            </div>

            <!-- Save Profile -->
            <button type="submit">Save Profile</button>
        </form>

        <hr>

        <h2>Job Applications</h2>
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Applied On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobApplications as $application)
                    <tr>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ $application->job->company->name }}</td>
                        <td>{{ $application->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
