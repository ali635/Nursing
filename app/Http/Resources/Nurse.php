<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Nurse extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            // 'password'     => $this->password,
            'mobile'       => $this->mobile,
            'gender'       => $this->gender,
            'age'          => $this->age,
            'photo'        => $this->photo,
            'accepet'      => $this->accepet,
            'rememberToken'=> $this->rememberToken,
            'created_at'   => $this->created_at->format('d/m/Y'),
            'updated_at'   => $this->updated_at->format('d/m/Y'),

        ];
    }
}
