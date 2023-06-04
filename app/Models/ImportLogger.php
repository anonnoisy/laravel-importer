<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportLogger extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'path',
        'logs',
        'status',
        'type',
        'import_by',
    ];

    /**
     * Get the user that owns the logs.
     */
    public function import_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'import_by', 'id');
    }
}
