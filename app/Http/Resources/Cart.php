<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return[
           'client_id'     => $this->client_id,
           'client_name'   => $this->client_name,
           'client_phone'  => $this->client_phone,
           'new_address'   => $this->new_address,
           'total'         => $this->total,
           'payment_method'=> $this->payment_method,
           'status'        => $this->status,
           'check'         => $this->check,
           'Payment_Date'  => $this->Payment_Date,
           'user_id'       => $this->user_id,
           'product_id'    => $this->product_id,
           'created_at'=> $this->created_at->format('d/m/Y'),
           'updated_at'=> $this->updated_at->format('d/m/Y'),

       ];
    }
}