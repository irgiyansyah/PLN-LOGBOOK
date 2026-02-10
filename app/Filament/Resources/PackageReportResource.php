<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageReportResource\Pages;
use App\Models\PackageReport; 
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\PackageExport; 
use Carbon\Carbon;

class PackageReportResource extends Resource
{
    protected static ?string $model = PackageReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Laporan Paket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Data Paket Masuk')
                    ->schema([
                        Forms\Components\TextInput::make('item_name')
                            ->label('Nama Barang / Paket')
                            ->required(),

                        Forms\Components\Select::make('condition')
                            ->label('Kondisi Barang')
                            ->options([
                                'Baik' => 'Baik',
                                'Rusak' => 'Rusak',
                                'Pecah' => 'Pecah',
                            ])
                            ->required(),

                        // GANTI JADI receiver_name
                        Forms\Components\TextInput::make('receiver_name') 
                            ->label('Nama Penerima')
                            ->required(),

                        Forms\Components\DatePicker::make('received_date')
                            ->label('Tanggal Diterima')
                            ->default(now())
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('received_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_name')
                    ->label('Barang')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('condition')
                    ->label('Kondisi')
                    ->badge(),

                // GANTI JADI receiver_name JUGA DI SINI
                Tables\Columns\TextColumn::make('receiver_name')
                    ->label('Penerima')
                    ->searchable(),
            ])
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
                        $filename = 'Laporan_Paket_' . $start . '_sd_' . $end . '.xlsx';
                        return Excel::download(new PackageExport($start, $end), $filename);
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
    
    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackageReports::route('/'),
            'create' => Pages\CreatePackageReport::route('/create'),
            'edit' => Pages\EditPackageReport::route('/{record}/edit'),
        ];
    }
}