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
 * @property string description
 * @property string link
 */
class Invoice extends Model {

    /**
     * New invoice
     */
    const STATUS_NEW = 'NEW';

    /**
     * Completed status
     */
    const STATUS_COMPLETED = 'PAID';

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'description',
        'school_id',
        'invoice_number',
        'status',
        'link'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function school() {

        return $this->hasOne(School::class, 'id', 'school_id');
    }
}
