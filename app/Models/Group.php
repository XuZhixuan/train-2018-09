<?php

namespace App\Models;

/**
 * Class Group
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property string $domain_name
 * @property string $ftp_username
 * @property string $ftp_password
 * @property string $db_username
 * @property string $db_password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection $users
 */
class Group extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * @param $ftp_password
     * @return string
     */
    public function getFtpPasswordAttribute($ftp_password)
    {
        return decrypt($ftp_password);
    }

    /**
     * @param $db_password
     * @return string
     */
    public function getDbPasswordAttribute($db_password)
    {
        return decrypt($db_password);
    }
}
