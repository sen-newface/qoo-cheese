<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Photo as PhotoResource;

class Event extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user->id,
      'name' => $this->name,
      'key'  => $this->key,
      'start_date' => $this->start_date,
      'end_date' => $this->end_date,
      'photos' => PhotoResource::collection($this->photos)
    ];
  }
}
