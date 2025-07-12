<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LowStockAlert extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Alert';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        try {
            return Auth::user()?->can('dashboard.products') ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 10)
                    ->orderBy('stock', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('stock')
                    ->label('Current Stock')
                    ->sortable()
                    ->color(fn ($record) => $record->stock <= 5 ? 'danger' : 'warning')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Update Stock')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Product $record): string => route('filament.admin.resources.products.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('stock', 'asc');
    }
} 