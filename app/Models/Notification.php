<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["title", "body"];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "notifications";

    /**
     * Relationship with Appointment model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment');
    }
}
