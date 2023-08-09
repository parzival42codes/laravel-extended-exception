<?php

namespace parzival42codes\LaravelExtendedException\App\Services;

use Illuminate\Support\Facades\Log;
use parzival42codes\LaravelExtendedException\App\Exceptions\ExtendedException;
use Throwable;

class ExtendedExceptionService
{
    private string $message = '';

    private string $title = '';

    private string $text = '';

    private string $debugMessage = '';

    private string $template = '';

    private array $context = [];

    private ?Throwable $previous = null;

    private int|string $status = 500;

    public function __construct(string $message)
    {
        $this->message = $message;

        if (! $this->title) {
            $this->title = __('extendedException.title');
        }

        if (! $this->text) {
            $this->text = __('extendedException.text');
        }
    }

    public function throw(): void
    {
        $context = [
            'title' => $this->title, 'text' => $this->text, 'template' => $this->template,
            'debugMessage' => $this->debugMessage, 'context' => $this->context, 'status' => $this->status,
        ];

        if ($this->previous instanceof Throwable) {
            $context['previousException'] = [
                'message' => $this->previous->getMessage(),
                'file' => $this->previous->getFile(),
                'line' => $this->previous->getLine(),
            ];
        }

        $contextEncode = json_encode($context);
        Log::error($this->message, $context);

        if (is_string($contextEncode)) {
            if (PHP_SAPI !== 'cli') {
                throw new ExtendedException($this->message.'|||'.base64_encode($contextEncode));
            }

            throw new ExtendedException($this->message.' '.json_encode($contextEncode));
        }

        throw new ExtendedException($this->message);
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function debugMessage(string $debugMessage): self
    {
        $this->debugMessage = $debugMessage;

        return $this;
    }

    public function context(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function template(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function status(string|int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function previous(Throwable $previous): self
    {
        $this->previous = $previous;

        return $this;
    }
}
