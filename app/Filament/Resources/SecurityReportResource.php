<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SecurityReportResource\Pages;
use App\Models\SecurityReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Import Komponen Form
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Group;
// Import Plugin TTD
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
// Import Komponen Table & Filter
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;

class SecurityReportResource extends Resource
{
    protected static ?string $model = SecurityReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Laporan Satpam';

    protected static ?string $modelLabel = 'Laporan Satpam'; // Untuk singular (1 Laporan)
    protected static ?string $pluralModelLabel = 'Laporan Satpam'; // Untuk plural (Banyak Laporan)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- BAGIAN 1: KOP SURAT ---
                Section::make('Header Laporan')
                    ->description('Data Shift dan Waktu Jaga')
                    ->schema([
                        DatePicker::make('report_date')
                            ->label('Tanggal Laporan')
                            ->default(now())
                            ->required(),
                        Select::make('shift')
                            ->options([
                                'Pagi' => 'Pagi (07.00 - 15.00)',
                                'Sore' => 'Sore (15.00 - 23.00)',
                                'Malam' => 'Malam (23.00 - 07.00)',
                            ])
                            ->required(),
                        TimePicker::make('start_time')->label('Jam Mulai')->required(),
                        TimePicker::make('end_time')->label('Jam Selesai')->required(),
                        
                        // KOLOM TTD PENYERAH
                        Group::make()
                            ->schema([
                                TextInput::make('handover_from')
                                    ->label('Nama Yang Menyerahkan')
                                    ->required(),
                                SignaturePad::make('signature_from')
                                    ->label('Tanda Tangan Penyerah')
                                    ->dotSize(2.0)
                                    ->lineMinWidth(0.5)
                                    ->lineMaxWidth(2.5)
                                    ->throttle(16)
                            ])->columnSpan(1),

                        // KOLOM TTD PENERIMA
                        Group::make()
                            ->schema([
                                TextInput::make('handover_to')
                                    ->label('Nama Yang Menerima')
                                    ->required(),
                                SignaturePad::make('signature_to')
                                    ->label('Tanda Tangan Penerima')
                                    ->dotSize(2.0)
                                    ->lineMinWidth(0.5)
                                    ->lineMaxWidth(2.5)
                                    ->throttle(16)
                            ])->columnSpan(1),

                        Select::make('area_status')
                            ->options(['Aman' => 'Aman', 'Rawan' => 'Rawan', 'Insiden' => 'Ada Insiden'])
                            ->default('Aman')
                            ->label('Status Keamanan')
                            ->columnSpanFull(),
                    ])->columns(2),

                // --- BAGIAN 2: PERSONIL ---
                Section::make('Daftar Personil Jaga')
                    ->schema([
                        Repeater::make('personnels')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')->label('Nama Lengkap')->required(),
                                TextInput::make('role')->default('Satpam')->label('Jabatan'),
                                Select::make('attendance_status')
                                    ->options(['Hadir' => 'Hadir', 'Izin' => 'Izin', 'Sakit' => 'Sakit'])
                                    ->default('Hadir'),
                            ])->columns(3)->addActionLabel('Tambah Petugas')
                    ]),

                // --- BAGIAN 3: INVENTARIS ---
                Section::make('Daftar Inventaris')
                    ->schema([
                        Repeater::make('inventories')
                            ->relationship()
                            ->schema([
                                TextInput::make('item_name')->label('Nama Barang')->required(),
                                TextInput::make('quantity')->numeric()->default(1)->label('Jumlah'),
                                Select::make('condition')
                                    ->options(['Baik' => 'Baik', 'Rusak' => 'Rusak', 'Hilang' => 'Hilang'])
                                    ->default('Baik'),
                                TextInput::make('remarks')->label('Ket.'),
                            ])->columns(4)->addActionLabel('Tambah Barang')
                    ]),

                // --- BAGIAN 4: LOGBOOK ---
                Section::make('Logbook Kegiatan')
                    ->schema([
                        Repeater::make('activities')
                            ->relationship()
                            ->schema([
                                TimePicker::make('log_time')->label('Pukul')->required(),
                                Textarea::make('description')->label('Uraian')->rows(2)->required(),
                            ])->addActionLabel('Catat Kejadian')
                            ]),
                                        // --- BAGIAN BARU: LAMPIRAN FOTO ---
                Section::make('Lampiran Dokumentasi')
                    ->schema([
                        FileUpload::make('evidence_photo')
                            ->label('Foto Bukti Lapangan')
                            ->image() // Hanya boleh upload gambar
                            ->directory('laporan-evidence') // Folder penyimpanan
                            ->columnSpanFull() // Lebar penuh
                            ->downloadable() // Bisa didownload
                            ->previewable(true), // Bisa dipreview
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('report_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('shift')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pagi' => 'info',
                        'Sore' => 'warning',
                        'Malam' => 'purple',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('handover_from')
                    ->label('Serah Terima')
                    ->description(fn (SecurityReport $record): string => '→ ' . $record->handover_to)
                    ->searchable(),

                Tables\Columns\TextColumn::make('personnels_count')
                    ->counts('personnels')
                    ->label('Jumlah Petugas')
                    ->badge(),

                Tables\Columns\TextColumn::make('area_status')
                    ->label('Situasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aman' => 'success',
                        'Rawan' => 'danger',
                        'Insiden' => 'danger',
                    }),
            ])
            ->defaultSort('report_date', 'desc')
            ->filters([
                SelectFilter::make('shift')
                    ->options([
                        'Pagi' => 'Pagi',
                        'Sore' => 'Sore',
                        'Malam' => 'Malam',
                    ]),
                
                SelectFilter::make('area_status')
                    ->options([
                        'Aman' => 'Aman',
                        'Rawan' => 'Rawan',
                        'Insiden' => 'Ada Insiden',
                    ]),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('report_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('report_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // --- INI TOMBOL CETAK PDF NYA ---
                Tables\Actions\Action::make('pdf') 
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->color('success') 
                    ->url(fn (SecurityReport $record) => route('security_reports.pdf', $record))
                    ->openUrlInNewTab(), 
                // --------------------------------

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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSecurityReports::route('/'),
            'create' => Pages\CreateSecurityReport::route('/create'),
            'edit' => Pages\EditSecurityReport::route('/{record}/edit'),
        ];
    }
}