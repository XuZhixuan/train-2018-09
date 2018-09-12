<?php

namespace App\Models;

/**
 * Class Department
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $members_count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $members
 */
class Department extends Model
{
    public function members()
    {
        return $this->hasMany('App\Models\User');
    }
}
