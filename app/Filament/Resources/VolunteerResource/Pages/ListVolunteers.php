<?php

namespace App\Filament\Resources\VolunteerResource\Pages;

use App\Filament\Resources\VolunteerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVolunteers extends ListRecords
{
    protected static string $resource = VolunteerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),  // إضافة زر لإنشاء متطوع جديد
        ];
    }
}
