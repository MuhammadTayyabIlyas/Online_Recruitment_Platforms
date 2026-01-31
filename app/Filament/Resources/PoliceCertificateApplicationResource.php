<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoliceCertificateApplicationResource\Pages;
use App\Models\PoliceCertificateApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class PoliceCertificateApplicationResource extends Resource
{
    protected static ?string $model = PoliceCertificateApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Services';

    protected static ?string $navigationLabel = 'Police Certificates';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'application_reference';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'submitted')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('status', 'submitted')->count();
        return $pendingCount > 0 ? 'warning' : 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Application Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'payment_pending' => 'Payment Pending',
                                'payment_verified' => 'Payment Verified',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('service_type')
                            ->options([
                                'normal' => 'Normal (14 days)',
                                'urgent' => 'Urgent (7 days)',
                            ])
                            ->disabled(),

                        Forms\Components\TextInput::make('payment_amount')
                            ->prefix(fn ($record) => $record?->payment_currency === 'gbp' ? '£' : '€')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('payment_verified_at')
                            ->label('Payment Verified At'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')->disabled(),
                        Forms\Components\TextInput::make('middle_name')->disabled(),
                        Forms\Components\TextInput::make('last_name')->disabled(),
                        Forms\Components\TextInput::make('father_full_name')->disabled(),
                        Forms\Components\TextInput::make('gender')->disabled(),
                        Forms\Components\DatePicker::make('date_of_birth')->disabled(),
                        Forms\Components\TextInput::make('place_of_birth_city')->disabled(),
                        Forms\Components\TextInput::make('place_of_birth_country')->disabled(),
                        Forms\Components\TextInput::make('nationality')->disabled(),
                        Forms\Components\TextInput::make('marital_status')->disabled(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Identity Documents')
                    ->schema([
                        Forms\Components\TextInput::make('passport_number')->disabled(),
                        Forms\Components\DatePicker::make('passport_issue_date')->disabled(),
                        Forms\Components\DatePicker::make('passport_expiry_date')->disabled(),
                        Forms\Components\TextInput::make('passport_place_of_issue')->disabled(),
                        Forms\Components\TextInput::make('cnic_nicop_number')->disabled(),
                        Forms\Components\TextInput::make('uk_home_office_ref')->disabled(),
                        Forms\Components\TextInput::make('uk_brp_number')->disabled(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')->disabled(),
                        Forms\Components\TextInput::make('phone_spain')->disabled(),
                        Forms\Components\TextInput::make('whatsapp_number')->disabled(),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Spain Address')
                    ->schema([
                        Forms\Components\TextInput::make('spain_address_line1')->disabled(),
                        Forms\Components\TextInput::make('spain_address_line2')->disabled(),
                        Forms\Components\TextInput::make('spain_city')->disabled(),
                        Forms\Components\TextInput::make('spain_province')->disabled(),
                        Forms\Components\TextInput::make('spain_postal_code')->disabled(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Admin Notes')
                    ->schema([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Internal Notes')
                            ->rows(3)
                            ->placeholder('Add any internal notes about this application...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('application_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Reference copied'),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Applicant')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'submitted',
                        'info' => 'payment_pending',
                        'primary' => 'payment_verified',
                        'purple' => 'processing',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-pencil' => 'draft',
                        'heroicon-o-clock' => 'submitted',
                        'heroicon-o-banknotes' => 'payment_pending',
                        'heroicon-o-check-circle' => 'payment_verified',
                        'heroicon-o-cog' => 'processing',
                        'heroicon-o-check-badge' => 'completed',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                Tables\Columns\BadgeColumn::make('service_type')
                    ->colors([
                        'primary' => 'normal',
                        'danger' => 'urgent',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('payment_amount_display')
                    ->label('Amount')
                    ->sortable('payment_amount'),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->since(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'payment_pending' => 'Payment Pending',
                        'payment_verified' => 'Payment Verified',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'rejected' => 'Rejected',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('service_type')
                    ->options([
                        'normal' => 'Normal',
                        'urgent' => 'Urgent',
                    ]),

                Tables\Filters\Filter::make('submitted_at')
                    ->form([
                        Forms\Components\DatePicker::make('submitted_from')
                            ->label('Submitted From'),
                        Forms\Components\DatePicker::make('submitted_until')
                            ->label('Submitted Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['submitted_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_at', '>=', $date),
                            )
                            ->when(
                                $data['submitted_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('verify_payment')
                    ->label('Verify Payment')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Verify Payment')
                    ->modalDescription('Are you sure you want to mark this payment as verified?')
                    ->visible(fn ($record) => in_array($record->status, ['submitted', 'payment_pending']))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'payment_verified',
                            'payment_verified_at' => now(),
                            'payment_verified_by' => auth()->id(),
                        ]);
                    }),

                Tables\Actions\Action::make('start_processing')
                    ->label('Start Processing')
                    ->icon('heroicon-o-cog')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'payment_verified')
                    ->action(fn ($record) => $record->update(['status' => 'processing'])),

                Tables\Actions\Action::make('mark_completed')
                    ->label('Mark Completed')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'processing')
                    ->action(fn ($record) => $record->update(['status' => 'completed'])),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Application')
                    ->modalDescription('Are you sure you want to reject this application? This action should be used carefully.')
                    ->visible(fn ($record) => !in_array($record->status, ['completed', 'rejected']))
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify_payments')
                        ->label('Verify Payments')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if (in_array($record->status, ['submitted', 'payment_pending'])) {
                                    $record->update([
                                        'status' => 'payment_verified',
                                        'payment_verified_at' => now(),
                                        'payment_verified_by' => auth()->id(),
                                    ]);
                                }
                            });
                        }),

                    Tables\Actions\BulkAction::make('start_processing_bulk')
                        ->label('Start Processing')
                        ->icon('heroicon-o-cog')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->status === 'payment_verified') {
                                    $record->update(['status' => 'processing']);
                                }
                            });
                        }),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->poll('30s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Application Overview')
                    ->schema([
                        Infolists\Components\Grid::make(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('application_reference')
                                    ->label('Reference')
                                    ->weight('bold')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'draft' => 'gray',
                                        'submitted' => 'warning',
                                        'payment_pending' => 'info',
                                        'payment_verified' => 'primary',
                                        'processing' => 'purple',
                                        'completed' => 'success',
                                        'rejected' => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('service_type')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => $state === 'urgent' ? 'Urgent (7 days)' : 'Normal (14 days)')
                                    ->color(fn (string $state): string => $state === 'urgent' ? 'danger' : 'primary'),
                                Infolists\Components\TextEntry::make('payment_amount_display')
                                    ->label('Amount'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Personal Information')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('full_name')
                                    ->label('Full Name'),
                                Infolists\Components\TextEntry::make('father_full_name')
                                    ->label("Father's Name"),
                                Infolists\Components\TextEntry::make('gender')
                                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                                Infolists\Components\TextEntry::make('date_of_birth')
                                    ->date(),
                                Infolists\Components\TextEntry::make('place_of_birth_city')
                                    ->label('City of Birth'),
                                Infolists\Components\TextEntry::make('place_of_birth_country')
                                    ->label('Country of Birth'),
                                Infolists\Components\TextEntry::make('nationality'),
                                Infolists\Components\TextEntry::make('marital_status')
                                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Identity Documents')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('passport_number'),
                                Infolists\Components\TextEntry::make('passport_issue_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('passport_expiry_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('passport_place_of_issue'),
                                Infolists\Components\TextEntry::make('cnic_nicop_number')
                                    ->label('CNIC/NICOP'),
                                Infolists\Components\TextEntry::make('uk_national_insurance_number')
                                    ->label('UK NI Number')
                                    ->default('Not provided'),
                                Infolists\Components\TextEntry::make('uk_home_office_ref')
                                    ->label('Home Office Ref')
                                    ->default('Not provided'),
                                Infolists\Components\TextEntry::make('uk_brp_number')
                                    ->label('BRP Number')
                                    ->default('Not provided'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Contact Information')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('email')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('phone_spain')
                                    ->label('Phone (Spain)'),
                                Infolists\Components\TextEntry::make('whatsapp_number')
                                    ->label('WhatsApp')
                                    ->default('Not provided'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Spain Address')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('spain_address_line1')
                                    ->label('Address Line 1'),
                                Infolists\Components\TextEntry::make('spain_address_line2')
                                    ->label('Address Line 2')
                                    ->default('-'),
                                Infolists\Components\TextEntry::make('spain_city')
                                    ->label('City'),
                                Infolists\Components\TextEntry::make('spain_province')
                                    ->label('Province'),
                                Infolists\Components\TextEntry::make('spain_postal_code')
                                    ->label('Postal Code'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('UK Residence History')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('uk_residence_history')
                            ->schema([
                                Infolists\Components\TextEntry::make('entry_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('exit_date')
                                    ->date()
                                    ->default('Present'),
                                Infolists\Components\TextEntry::make('visa_category'),
                                Infolists\Components\TextEntry::make('notes')
                                    ->default('-'),
                            ])
                            ->columns(4),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('UK Address History')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('uk_address_history')
                            ->schema([
                                Infolists\Components\TextEntry::make('address_line1'),
                                Infolists\Components\TextEntry::make('city'),
                                Infolists\Components\TextEntry::make('postcode'),
                                Infolists\Components\TextEntry::make('from_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('to_date')
                                    ->date()
                                    ->default('Present'),
                            ])
                            ->columns(5),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        Infolists\Components\Grid::make(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('submitted_at')
                                    ->label('Submitted')
                                    ->dateTime(),
                                Infolists\Components\TextEntry::make('payment_verified_at')
                                    ->label('Payment Verified')
                                    ->dateTime()
                                    ->default('Not yet'),
                                Infolists\Components\TextEntry::make('verifier.name')
                                    ->label('Verified By')
                                    ->default('-'),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PoliceCertificateApplicationResource\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoliceCertificateApplications::route('/'),
            'view' => Pages\ViewPoliceCertificateApplication::route('/{record}'),
            'edit' => Pages\EditPoliceCertificateApplication::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['application_reference', 'first_name', 'last_name', 'email', 'passport_number'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Applicant' => $record->full_name,
            'Status' => ucfirst(str_replace('_', ' ', $record->status)),
        ];
    }
}
