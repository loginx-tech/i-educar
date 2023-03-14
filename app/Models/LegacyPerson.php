<?php

namespace App\Models;

use App\Models\Builders\LegacyPersonBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @property string $name
 */
class LegacyPerson extends LegacyModel
{
    public const CREATED_AT = 'data_cad';
    public const UPDATED_AT = 'data_rev';

    /**
     * @var string
     */
    protected $table = 'cadastro.pessoa';

    /**
     * @var string
     */
    protected $primaryKey = 'idpes';

    protected string $builder = LegacyPersonBuilder::class;

    /**
     * @var array
     */
    protected $dates = [
        'data_cad',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'nome',
        'data_cad',
        'tipo',
        'situacao',
        'origem_gravacao',
        'operacao',
        'email'
    ];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->data_cad = now();
            $model->situacao = 'I';
            $model->origem_gravacao = 'M';
            $model->operacao = 'I';
            $model->slug = Str::lower(Str::slug($model->nome, ' '));

            if (config('legacy.app.uppercase_names')) {
                $model->nome = Str::upper($model->nome);
            }
        });
    }

    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->idpes
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () =>  $this->nome
        );
    }

    protected function socialName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->individual->social_name ?? null
        );
    }

    /**
     * @return HasMany
     */
    public function phone(): HasMany
    {
        return $this->hasMany(LegacyPhone::class, 'idpes', 'idpes');
    }

    /**
     * @return HasOne
     */
    public function individual(): HasOne
    {
        return $this->hasOne(LegacyIndividual::class, 'idpes', 'idpes');
    }

    /**
     * @return BelongsToMany
     */
    public function deficiencies(): BelongsToMany
    {
        return $this->belongsToMany(
            LegacyDeficiency::class,
            'cadastro.fisica_deficiencia',
            'ref_idpes',
            'ref_cod_deficiencia',
            'idpes',
            'cod_deficiencia'
        );
    }

    /**
     * @return HasOne
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'cod_servidor', 'idpes');
    }

    /**
     * @return BelongsToMany
     */
    public function considerableDeficiencies(): BelongsToMany
    {
        return $this->deficiencies()->where('desconsidera_regra_diferenciada', false);
    }
}
