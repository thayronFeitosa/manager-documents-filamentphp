<?php

namespace App\Filament\Resources\TypeDocumentResource\Pages;

use App\Filament\Resources\TypeDocumentResource;
use App\Services\TypeDocument\TypeDocumentInterface;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTypeDocument extends EditRecord
{
    protected static string $resource = TypeDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        if (resolve(TypeDocumentInterface::class)->isUpdate($this->data['name'],  $this->data['user_id'], $this->data['id'])) {
            Notification::make()
                ->title(__('Tipo de documento já existente'))
                ->body(__('Já existe um tipo de documento cadastrado com o nome.'))
                ->warning()
                ->send();

            $this->halt();
        }
    }
}
