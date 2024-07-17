<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    protected $fillable = [
        'item_name',
        'value',
        'search_form_id',
    ];

    public function searchForm(): BelongsTo
    {
        return $this->belongsTo(SearchForm::class, 'search_form_id');
    }

    public function errorMessages(): HasMany
    {
        return $this->hasMany(ErrorMessage::class, 'form_field_id');
    }
}