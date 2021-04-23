<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);
        return[
            'id'           => $this->id,
            'name'         => $this->name,
            'mobile'       => $this->mobile,
            'address'      => $this->address,
            'longitude'    => $this->longitude,
            'latitude'     => $this->latitude,
            'rememberToken'=> $this->rememberToken,
            'created_at'   => $this->created_at->format('d/m/Y'),
            'updated_at'   => $this->updated_at->format('d/m/Y'),

        ];
    }
}
