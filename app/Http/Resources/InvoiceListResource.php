<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class InvoiceList
 * @package App\Http\Resources
 */
class InvoiceListResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'invoice_number' => $this->invoice_number,
            'description' => $this->description,
            'school_name' => $this->school ? $this->school->name : '',
            'full_name' => $this->school ? $this->user->full_name : '',
            'status' => $this->status,
            'link' => config('app.url'). "/" . $this->link,
        ];
    }
}
