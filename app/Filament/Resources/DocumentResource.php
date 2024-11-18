<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use App\Models\TypeDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

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
                    ->relationship('typeDocument', 'name')
                    ->searchable()
                    ->options(fn () => TypeDocument::where('user_id', auth()->id())
                        ->pluck('name', 'id'))
                    ->getSearchResultsUsing(fn (string $search) => TypeDocument::where('user_id', auth()->id())
                        ->where('name', 'like', "%{$search}%")
                        ->pluck('name', 'id'))

                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome do Tipo de Documento')
                            ->required()
                            ->maxLength(255)
                            ->rules(fn() => [
                                Rule::unique('type_documents', 'name')
                                    ->where('user_id', auth()->id())
                            ])
                            ->validationMessages([
                                'unique' => 'O :attribute já existe.',
                            ])

                    ])
                ->required(),
                Forms\Components\TextInput::make('descriptions')
                    ->label('Descrição')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dateOfPayment')
                    ->label('Data de Pagamento')
                    ->required(),
                Forms\Components\DatePicker::make('dueDate')
                    ->label('Data de Vencimento')
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('document')
                    ->label('Anexo')
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
