<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 * @package App\Models
 * @property string name
 */
class School extends Model {

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];
}
