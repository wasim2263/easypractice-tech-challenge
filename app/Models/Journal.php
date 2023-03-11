<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'deleted_at'
    ];
    protected $fillable = [
        'client_id',
        'date',
        'text'
    ];
    protected $dates=[
        'date'
    ];
    protected $appends = [
      'journal_date'
    ];
    public function getJournalDateAttribute()
    {
        return $this->date->format('l d F Y');
    }
}
