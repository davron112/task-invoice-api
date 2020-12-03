<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 * @property integer amount
 * @property string description
 * @property integer status
 * @property integer payer_id
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
        'payer_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne(User::class, 'id', 'payer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice() {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
}
