<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;

class ProjectResource extends JsonResource
{
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
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'tasks_count' => $this->whenHas('tasks_count', $this->tasks_count),
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
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