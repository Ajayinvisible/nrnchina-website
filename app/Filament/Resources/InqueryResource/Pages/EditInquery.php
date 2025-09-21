<?php

namespace App\Filament\Resources\InqueryResource\Pages;

use App\Filament\Resources\InqueryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInquery extends EditRecord
{
    protected static string $resource = InqueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
