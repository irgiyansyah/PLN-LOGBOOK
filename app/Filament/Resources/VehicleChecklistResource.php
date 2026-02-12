<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleChecklistResource\Pages;
use App\Models\VehicleChecklist; // Pastikan Model ini benar
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleExport;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter; // Import Filter
use Illuminate\Database\Eloquent\Builder; // Import Builder

class VehicleChecklistResource extends Resource
{
    protected static ?string $model = VehicleChecklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Laporan Kendaraan';
    protected static ?string $modelLabel = 'Laporan Kendaraan';
    protected static ?string $pluralModelLabel = 'Laporan Kendaraan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Data Kendaraan')
                    ->schema([
                        Forms\Components\TextInput::make('driver_name')
                            ->label('Nama Driver')
                            ->required(),
                        Forms\Components\Select::make('vehicle_type')
                            ->label('Jenis Kendaraan')
                            ->options(['Mobil' => 'Mobil', 'Motor' => 'Motor', 'Truk' => 'Truk'])
                            ->required(),
                        Forms\Components\TextInput::make('license_plate')
                            ->label('Nomor Polisi')
                            ->required(),
                        Forms\Components\TimePicker::make('time_in')
                            ->label('Jam Masuk')
                            ->default(now())
                            ->required(),
                        Forms\Components\TimePicker::make('time_out')
                            ->label('Jam Keluar'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver_name')
                    ->label('Nama Driver')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('No. Polisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time_in')
                    ->label('Masuk')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('time_out')
                    ->label('Keluar')
                    ->time('H:i')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Keterangan')
                    ->limit(20),
            ])
            // --- BAGIAN FILTER TANGGAL DITAMBAHKAN DI SINI ---
            ->filters([
                Filter::make('created_at')
                    ->label('Rentang Tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            // ------------------------------------------------
            ->headerActions([
                Tables\Actions\Action::make('export_excel')
                    ->label('Download Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->form([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Dari Tanggal')
                            ->default(now()->startOfMonth())
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Sampai Tanggal')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $start = Carbon::parse($data['start_date'])->format('Y-m-d');
                        $end = Carbon::parse($data['end_date'])->format('Y-m-d');
                        $filename = 'Laporan_Kendaraan_' . $start . '_sd_' . $end . '.xlsx';
                        
                        return Excel::download(new VehicleExport($start, $end), $filename);
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleChecklists::route('/'),
            'create' => Pages\CreateVehicleChecklist::route('/create'),
            'edit' => Pages\EditVehicleChecklist::route('/{record}/edit'),
        ];
    }
}