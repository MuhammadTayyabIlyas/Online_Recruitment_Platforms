<?php

namespace App\Filament\Resources\PoliceCertificateApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Uploaded Documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_type')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_type')
            ->columns([
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Document Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'passport' => 'Passport',
                        'cnic' => 'CNIC/NICOP',
                        'brp' => 'BRP/Visa',
                        'receipt' => 'Payment Receipt',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'passport' => 'primary',
                        'cnic' => 'success',
                        'brp' => 'warning',
                        'receipt' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('original_filename')
                    ->label('File Name')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->original_filename),

                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match (true) {
                        str_contains($state, 'pdf') => 'PDF',
                        str_contains($state, 'jpeg') || str_contains($state, 'jpg') => 'JPEG',
                        str_contains($state, 'png') => 'PNG',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(function ($state) {
                        if ($state < 1024) return $state . ' B';
                        if ($state < 1048576) return round($state / 1024, 2) . ' KB';
                        return round($state / 1048576, 2) . ' MB';
                    }),

                Tables\Columns\TextColumn::make('description')
                    ->label('Notes')
                    ->limit(50)
                    ->default('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->options([
                        'passport' => 'Passport',
                        'cnic' => 'CNIC/NICOP',
                        'brp' => 'BRP/Visa',
                        'receipt' => 'Payment Receipt',
                    ]),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->url(fn ($record) => route('admin.police-certificate.download-document', $record))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn ($record) => route('admin.police-certificate.preview-document', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => str_contains($record->mime_type, 'image') || str_contains($record->mime_type, 'pdf')),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('download_selected')
                    ->label('Download Selected')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($records) {
                        // Handle bulk download
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
