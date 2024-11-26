<?php

namespace Wefabric\FilamentExcelImport\Filament;

use Wefabric\FilamentExcelImport\Filament\Pages;
use Wefabric\FilamentExcelImport\Filament\RelationManagers;
use Wefabric\FilamentExcelImport\Actions\DoImport;
use Wefabric\FilamentExcelImport\Actions\GetFilamentResourceFromImportClass;
use Wefabric\FilamentExcelImport\Models\ExcelImport;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class ExcelImportResource extends Resource
{
    protected static ?string $model = ExcelImport::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';

    protected static ?string $navigationGroup = 'Instellingen';


    public static function getNavigationGroup(): ?string
    {
        return config('excel-import.filament.navigation_group');
    }

    public static function getLabel(): ?string
    {
        return config('excel-import.filament.label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('path'),
                Tables\Columns\TextColumn::make('storage_disk'),
                Tables\Columns\TextColumn::make('excel_class'),
                Tables\Columns\TextColumn::make('imported_at')->dateTime(),
                Tables\Columns\TextColumn::make('failed_at')->dateTime(),
                Tables\Columns\TextColumn::make('errors')->html(),
                Tables\Columns\TextColumn::make('messages'),
                Tables\Columns\TextColumn::make('resource')
                    ->getStateUsing(function(ExcelImport $record) {
                        if($resourceClass = app(GetFilamentResourceFromImportClass::class)->execute($record)) {
                            return $resourceClass::getNavigationLabel();
                        }
                        return '';
                    })->url(function(ExcelImport $record) {
                        if($resourceClass = app(GetFilamentResourceFromImportClass::class)->execute($record)) {
                            return $resourceClass::getNavigationUrl();
                        }
                        return '';
                    })
                ,
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (ExcelImport $record) {
                        $fileName = str_replace('.txt', '.csv', $record->path);
                        return response()->streamDownload(function () use ($record, $fileName) {
                            $handle = fopen($record->getFilePath(), 'r');
                            while (!feof($handle)) {
                                echo fgets($handle);
                            }
                            fclose($handle);
                        }, $fileName , [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('import')
                    ->label('Import')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            try {
                                (new DoImport())->execute($record);
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title($e->getMessage())
                                    ->warning()
                                    ->duration(15000)
                                    ->send();
                            }

                        }
                    }),
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => \Wefabric\FilamentExcelImport\Filament\Pages\ListExcelImports::route('/'),
            //'create' => \Domains\Excel\Filament\Pages\CreateExcelImport::route('/create'),
            //'edit' => \Domains\Excel\Filament\Pages\EditExcelImport::route('/{record}/edit'),
        ];
    }
}
