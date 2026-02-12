<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestBookResource\Pages;
use App\Models\GuestBook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestExport;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter; // Import Filter
use Illuminate\Database\Eloquent\Builder; // Import Builder

class GuestBookResource extends Resource
{
    protected static ?string $model = GuestBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Laporan Tamu';
    protected static ?string $modelLabel = 'Laporan Tamu';
    protected static ?string $pluralModelLabel = 'Laporan Tamu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Tambah Laporan Tamu')
                    ->description('Silakan isi data kunjungan tamu')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nama Tamu')
                            ->placeholder('Masukkan nama lengkap')
                            ->required(),

                        \Filament\Forms\Components\TextInput::make('institution')
                            ->label('Instansi')
                            ->placeholder('Asal Instansi / Perusahaan'),

                        \Filament\Forms\Components\TextInput::make('purpose')
                            ->label('Tujuan')
                            ->placeholder('Keperluan kunjungan')
                            ->required(),

                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('No. HP')
                            ->tel()
                            ->placeholder('08xxxxxxxxxx'),

                        \Filament\Forms\Components\DatePicker::make('visit_date')
                            ->label('Tanggal')
                            ->default(now())
                            ->required(),

                        \Saade\FilamentAutograph\Forms\Components\SignaturePad::make('signature')
                            ->label('Tanda Tangan')
                            ->dotSize(2.0)
                            ->columnSpanFull(),

                        \Filament\Forms\Components\FileUpload::make('photo')
                            ->label('Foto')
                            ->image()
                            ->directory('tamu-photos')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),

                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('institution')
                    ->label('Instansi')
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('visit_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('purpose')
                    ->label('Tujuan')
                    ->limit(30),
            ])
            // --- BAGIAN FILTER TANGGAL DITAMBAHKAN DI SINI ---
            ->filters([
                Filter::make('visit_date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('visit_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('visit_date', '<=', $date),
                            );
                    })
            ])
            // ------------------------------------------------
            ->headerActions([
                \Filament\Tables\Actions\Action::make('export_excel')
                    ->label('Download Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Dari Tanggal')
                            ->default(now()->startOfMonth())
                            ->required(),
                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('Sampai Tanggal')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $start = Carbon::parse($data['start_date'])->format('Y-m-d');
                        $end = Carbon::parse($data['end_date'])->format('Y-m-d');
                        
                        $filename = 'Laporan_Tamu_' . $start . '_sd_' . $end . '.xlsx';

                        return Excel::download(new GuestExport($start, $end), $filename);
                    }),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListGuestBooks::route('/'),
            'create' => Pages\CreateGuestBook::route('/create'),
            'edit' => Pages\EditGuestBook::route('/{record}/edit'),
        ];
    }
}