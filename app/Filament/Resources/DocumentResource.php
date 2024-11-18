<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('typeDocumentId')
                ->label('Tipo de Documento')
                ->options(function () {
                    return \App\Models\TypeDocument::where('user_id', auth()->id())
                        ->pluck('name', 'id');
                })
                ->required()
                ->searchable() // Permite buscar no select
                ->placeholder('Selecione um tipo de documento'), // Placeholder no select
                Forms\Components\TextInput::make('descriptions')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dateOfPayment')
                    ->required(),
                Forms\Components\DatePicker::make('dueDate')
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('document')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('typeDocument.name')
                ->label('Tipo de Documento')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('dateOfPayment')
                ->label('Data de Pagamento')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('dueDate')
                ->label('Data de Vencimento')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('descriptions')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_image_or_pdf')
                ->label('Ver Arquivo')
                ->icon('heroicon-o-eye')
                ->modalHeading('Visualizar Arquivo')
                ->modalContent(fn($record) => view('filament.resources.document.modal.view_file', [
                    'fileUrl' => $record->document ? storage_path("app/public/{$record->document}") : null,
                    'fileType' => $record->document ? pathinfo($record->document, PATHINFO_EXTENSION) : null,
                ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
