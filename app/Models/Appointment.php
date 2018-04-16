<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["title", "description", "appointment_date", "appoinment_type", "notification_date"];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = "appointments";

    /**
     * Relationship with User model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}