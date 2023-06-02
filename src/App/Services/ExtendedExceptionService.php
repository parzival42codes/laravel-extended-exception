<?php

namespace parzival42codes\LaravelExtendedException\App\Services;

use parzival42codes\LaravelExtendedException\App\Exceptions\ExtendedException;
use Throwable;

class ExtendedExceptionService
{
    private string $message = '';

    private string $title = '';

    private string $text = '';

    private string $debugMessage = '';

    private array $context = [];

    private Throwable $parentException;

    private int $status = 404;

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

    public function throw(): self
    {
        $context = [
            'title' => $this->title, 'text' => $this->text,
            'debugMessage' => $this->debugMessage, 'context' => $this->context, 'status' => $this->status,
        ];

        \Log::error($this->message, $context);
        throw new ExtendedException($this->message.'|||'.base64_encode(json_encode($context)));
    }

    /**
     * @param  string  $title
     * @return ExtendedExceptionService
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  string  $text
     * @return ExtendedExceptionService
     */
    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param  string  $debugMessage
     * @return ExtendedExceptionService
     */
    public function debugMessage(string $debugMessage): self
    {
        $this->debugMessage = $debugMessage;

        return $this;
    }

    /**
     * @param  array  $context
     * @return ExtendedExceptionService
     */
    public function context(array $context): self
    {
        $this->context = $context;

        return $this;
    }
}
