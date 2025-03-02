<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('title')
                    ->autofocus()
                    ->required(),
                Textarea::make('description')
                    ->rows(3),
                Select::make('status')
                    ->options(Ticket::STATUS)
                    ->default('backlog')
                    ->required(),
                Select::make('priority')
                    ->options(Ticket::PRIORITY)
                    ->default('low')
                    ->required(),
                Select::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->required(),
                TextArea::make('comment')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->modifyQueryUsing(
            //     fn(Builder $query) =>
            //     auth()->user()->hasRole(Role::ROLES['Admin']) ?
            //         $query : $query->where('assigned_to', auth()->id())
            // )
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->description(fn(Ticket $record): ?string => $record?->description ?? null)
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('status')
                    ->options(self::$model::STATUS),
                TextColumn::make('priority')
                    ->badge(),
                // ->colors([
                //     'warning' => self::$model::PRIORITY['Medium'],
                //     'success' => self::$model::PRIORITY['Low'],
                //     'danger' => self::$model::PRIORITY['High'],
                // ]),
                TextColumn::make('assignedTo.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignedBy.name')
                    ->searchable()
                    ->sortable(),
                TextInputColumn::make('comment'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(self::$model::STATUS)
                    ->placeholder('Filter By Status'),
                SelectFilter::make('priority')
                    ->options(self::$model::PRIORITY)
                    ->placeholder('Filter By Priority'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
