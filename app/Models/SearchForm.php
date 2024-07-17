<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function formFields()
    {
        return $this->hasMany(FormField::class, 'search_form_id');
    }

    public function searchResults()
    {
        return $this->hasMany(SearchResult::class, 'search_form_id');
    }
}