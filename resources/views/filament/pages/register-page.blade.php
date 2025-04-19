<x-filament::page>
    <x-filament::form wire:submit.prevent="submit">
        <x-filament::input name="name" label="Name" required />
        <x-filament::input name="email" label="Email" required />
        <x-filament::input name="password" label="Password" type="password" required />
        <x-filament::input name="password_confirmation" label="Confirm Password" type="password" required />
        
        <x-filament::select name="role" label="Choose Role" :options="['volunteer' => 'Volunteer', 'company' => 'Company']" />

        <x-filament::button type="submit">Register</x-filament::button>
    </x-filament::form>
</x-filament::page>
    