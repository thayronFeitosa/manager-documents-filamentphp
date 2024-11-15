<?php

namespace App\Filament\Resources\TypeDocumentResource\Pages;

use App\Filament\Resources\TypeDocumentResource;
use App\Services\TypeDocument\TypeDocumentInterface;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTypeDocument extends CreateRecord
{
    protected static string $resource = TypeDocumentResource::class;

    protected function beforeCreate(): void
    {
        if (resolve(TypeDocumentInterface::class)->exists($this->data['name'],  $this->data['user_id'])) {
            Notification::make()
                ->title(__('Tipo de documento já existente'))
                ->body(__('Já existe um tipo de documento cadastrado com o nome fornecido.'))
                ->warning()
                ->send();

            $this->halt();
        }
    }
}
