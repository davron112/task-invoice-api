<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * @package App\Models
 *
 * @property integer amount
 * @property integer school_id
 * @property integer invoice_number
 * @property integer payer_id
 * @property string status
 * @property string link
 */
class Invoice extends Model {

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'school_id',
        'invoice_number',
        'status',
        'link',
        'payer_id'
    ];

    /**
     * New invoice
     */
    const STATUS_NEW = 'NEW';

    /**
     * Completed status
     */
    const STATUS_COMPLETED = 'COMPLETED';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user() {
        return $this->hasOne(User::class, 'id', 'payer_id');
    }
}
