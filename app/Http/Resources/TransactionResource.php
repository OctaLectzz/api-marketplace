<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice' => $this->invoice,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->user),
            'product_price' => $this->product_price,
            'shipping_price' => $this->shipping_price,
            'total_price' => $this->total_price,
            'courier' => $this->courier,
            'shipping_estimation' => $this->shipping_estimation,
            'shipping_description' => $this->shipping_description,
            'resi' => $this->resi,
            'note' => $this->note ? $this->note : 'N / A',
            'snap_token' => $this->snap_token,
            'shipping_status' => $this->shipping_status,
            'transaction_details' => TransactionDetailResource::collection($this->transactionDetails),
            'created_at' => $this->created_at
        ];
    }
}
