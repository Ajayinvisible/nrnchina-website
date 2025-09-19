<?php

namespace App\Filament\Resources\BreadCrumbResource\Pages;

use App\Filament\Resources\BreadCrumbResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBreadCrumb extends EditRecord
{
    protected static string $resource = BreadCrumbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
