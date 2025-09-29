<?php

namespace App\Filament\Resources;

use App\Enums\EnergyCertificate;
use App\Enums\PropertyCondition;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypology;
use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Category;
use App\Models\Property;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    
    protected static ?string $navigationLabel = 'Imóveis';
    
    protected static ?string $modelLabel = 'Imóvel';
    
    protected static ?string $pluralModelLabel = 'Imóveis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        // Tab 1: Dados
                        Forms\Components\Tabs\Tab::make('Dados')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Título')
                                    ->required()
                                    ->minLength(10)
                                    ->maxLength(120)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Descrição')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'undo',
                                    ]),
                            ]),
                        
                        // Tab 2: Preço & Tipologia
                        Forms\Components\Tabs\Tab::make('Preço & Tipologia')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Preço (€)')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('€')
                                    ->maxLength(12),
                                Forms\Components\Select::make('typology')
                                    ->label('Tipologia')
                                    ->required()
                                    ->options([
                                        PropertyTypology::T0->value => 'T0',
                                        PropertyTypology::T1->value => 'T1',
                                        PropertyTypology::T2->value => 'T2',
                                        PropertyTypology::T3->value => 'T3',
                                        PropertyTypology::T4->value => 'T4',
                                        PropertyTypology::T5->value => 'T5',
                                        PropertyTypology::T6->value => 'T6',
                                        PropertyTypology::TERRENO->value => 'Terreno',
                                        PropertyTypology::LOJA->value => 'Loja',
                                    ]),
                                Forms\Components\TextInput::make('area')
                                    ->label('Área (m²)')
                                    ->numeric()
                                    ->suffix('m²'),
                                Forms\Components\TextInput::make('bedrooms')
                                    ->label('Quartos')
                                    ->numeric()
                                    ->minValue(0),
                                Forms\Components\TextInput::make('bathrooms')
                                    ->label('Casas de Banho')
                                    ->numeric()
                                    ->minValue(0),
                                Forms\Components\TextInput::make('parking')
                                    ->label('Estacionamento')
                                    ->numeric()
                                    ->minValue(0),
                                Forms\Components\Select::make('condition')
                                    ->label('Condição')
                                    ->required()
                                    ->options([
                                        PropertyCondition::NOVO->value => 'Novo',
                                        PropertyCondition::USADO->value => 'Usado',
                                        PropertyCondition::RENOVADO->value => 'Renovado',
                                        PropertyCondition::EM_CONSTRUCAO->value => 'Em Construção',
                                    ]),
                                Forms\Components\Select::make('status')
                                    ->label('Estado')
                                    ->required()
                                    ->options([
                                        PropertyStatus::ATIVO->value => 'Ativo',
                                        PropertyStatus::RESERVADO->value => 'Reservado',
                                        PropertyStatus::VENDIDO->value => 'Vendido',
                                        PropertyStatus::RASCUNHO->value => 'Rascunho',
                                    ])
                                    ->default(PropertyStatus::RASCUNHO->value),
                            ])->columns(2),
                        
                        // Tab 3: Localização
                        Forms\Components\Tabs\Tab::make('Localização')
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->label('Morada')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('city')
                                    ->label('Cidade')
                                    ->maxLength(120),
                                Forms\Components\TextInput::make('district')
                                    ->label('Distrito')
                                    ->maxLength(120),
                                Forms\Components\TextInput::make('parish')
                                    ->label('Freguesia')
                                    ->maxLength(120),
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->step(0.0000001),
                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->step(0.0000001),
                            ])->columns(2),
                        
                        // Tab 4: Media
                        Forms\Components\Tabs\Tab::make('Media')
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Imagem de Capa')
                                    ->image()
                                    ->disk('public')
                                    ->directory('properties/covers')
                                    ->visibility('public')
                                    ->maxSize(5120)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('gallery')
                                    ->label('Galeria')
                                    ->image()
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('properties/gallery')
                                    ->visibility('public')
                                    ->maxFiles(30)
                                    ->maxSize(5120)
                                    ->reorderable()
                                    ->columnSpanFull(),
                            ]),
                        
                        // Tab 5: SEO
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('Título SEO')
                                    ->maxLength(70)
                                    ->helperText('Máximo 70 caracteres'),
                                Forms\Components\Textarea::make('seo_description')
                                    ->label('Descrição SEO')
                                    ->maxLength(170)
                                    ->rows(3)
                                    ->helperText('Máximo 170 caracteres'),
                                Forms\Components\TextInput::make('canonical_url')
                                    ->label('URL Canónica')
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('noindex')
                                    ->label('Noindex (não indexar no Google)')
                                    ->default(false),
                            ])->columns(2),
                        
                        // Tab 6: Publicação & Extras
                        Forms\Components\Tabs\Tab::make('Publicação & Extras')
                            ->schema([
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Data de Publicação')
                                    ->default(now()),
                                Forms\Components\Select::make('energy_certificate')
                                    ->label('Certificado Energético')
                                    ->options([
                                        EnergyCertificate::A_PLUS->value => 'A+',
                                        EnergyCertificate::A->value => 'A',
                                        EnergyCertificate::B->value => 'B',
                                        EnergyCertificate::C->value => 'C',
                                        EnergyCertificate::D->value => 'D',
                                        EnergyCertificate::E->value => 'E',
                                        EnergyCertificate::F->value => 'F',
                                    ]),
                                Forms\Components\TextInput::make('year_built')
                                    ->label('Ano de Construção')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(date('Y')),
                                Forms\Components\Select::make('categories')
                                    ->label('Categorias')
                                    ->multiple()
                                    ->relationship('categories', 'name')
                                    ->preload(),
                                Forms\Components\Select::make('tags')
                                    ->label('Tags')
                                    ->multiple()
                                    ->relationship('tags', 'name')
                                    ->preload(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Imagem')
                    ->circular()
                    ->defaultImageUrl('https://via.placeholder.com/100x100.png?text=Sem+Imagem'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('typology')
                    ->label('Tipologia')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => PropertyStatus::ATIVO->value,
                        'warning' => PropertyStatus::RESERVADO->value,
                        'danger' => PropertyStatus::VENDIDO->value,
                        'secondary' => PropertyStatus::RASCUNHO->value,
                    ]),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        PropertyStatus::ATIVO->value => 'Ativo',
                        PropertyStatus::RESERVADO->value => 'Reservado',
                        PropertyStatus::VENDIDO->value => 'Vendido',
                        PropertyStatus::RASCUNHO->value => 'Rascunho',
                    ]),
                Tables\Filters\SelectFilter::make('typology')
                    ->label('Tipologia')
                    ->options([
                        PropertyTypology::T0->value => 'T0',
                        PropertyTypology::T1->value => 'T1',
                        PropertyTypology::T2->value => 'T2',
                        PropertyTypology::T3->value => 'T3',
                        PropertyTypology::T4->value => 'T4',
                        PropertyTypology::T5->value => 'T5',
                        PropertyTypology::T6->value => 'T6',
                        PropertyTypology::TERRENO->value => 'Terreno',
                        PropertyTypology::LOJA->value => 'Loja',
                    ]),
                Tables\Filters\SelectFilter::make('city')
                    ->label('Cidade')
                    ->options(fn () => Property::query()->distinct()->pluck('city', 'city')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
