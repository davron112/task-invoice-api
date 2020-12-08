<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 * @property integer amount
 * @property string description
 * @property integer status
 * @property integer full_name
 * @property integer invoice_id
 */
class Payment extends Model {

    /**
     * Unpaid status
     */
    const STATUS_UNPAID = 'UNPAID';
    /**
     * Payed status
     */
    const STATUS_PAYED = 'PAYED';

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'status',
        'invoice_id',
        'full_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice() {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
}
