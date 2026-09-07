<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected string $message = 'The project created';

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' =>  Carbon::parse($this->due_date)->format('d/m/Y'),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $originalData = $response->getData(true);

        $payload = [
            'success' => true,
            'message' => $this->message,
            'data'    => $originalData['data'] ?? $originalData,
        ];

        $response->setData($payload);
    }
}
