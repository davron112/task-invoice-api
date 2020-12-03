<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class PaymentList
 * @package App\Http\Resources
 */
class PaymentListResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'description' => $this->invoice->description,
            'school_name' => $this->invoice ? $this->invoice->school->name : '',
            'status' => $this->status
        ];
    }
}
