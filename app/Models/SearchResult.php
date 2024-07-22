<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    protected $fillable = ['data', 'search_form_id'];

    public function searchForm()
    {
        return $this->belongsTo(SearchForm::class, 'search_form_id');
    }
}