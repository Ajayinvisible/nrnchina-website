<?php

namespace App\Filament\Resources\PresidentResource\Pages;

use App\Filament\Resources\PresidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresident extends EditRecord
{
    protected static string $resource = PresidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
