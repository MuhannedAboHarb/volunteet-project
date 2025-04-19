<x-filament::page>
    @if($user && is_object($user)) 
    <div class="space-y-4">
            <h2 class="text-2xl font-semibold">User Details</h2>
            <div>
                <strong>Name:</strong> {{ $user->name }} <br>
                <strong>Email:</strong> {{ $user->email }} <br>
                <strong>Role:</strong> {{ $user->role }} <br>
                <strong>Social Status:</strong> {{ $user->social_status }} <br>
                <strong>Gender:</strong> {{ $user->gender }} <br>
                <strong>Phone:</strong> {{ $user->phone_number }} <br>
            </div>
        </div>
    @else
        <p>User data not found.</p>
    @endif
</x-filament::page>
