<?php

namespace parzival42codes\LaravelExtendedException\App\Exceptions;

use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Spatie\Backtrace\Backtrace;

class ExtendedException extends Exception
{
    public function render(): Response|ResponseFactory
    {
        $backtraceSource = Backtrace::createForThrowable($this)
            ->offset(1)
            ->frames();

        $backtraceTable = '';

        foreach ($backtraceSource as $count => $backtrace) {
            $backtraceTable .= '#' . $count . ' ' . $backtrace->file . '(' . $backtrace->lineNumber . '): ' . $backtrace->class . ' -> ' . $backtrace->method . '<br />';
        }

        $backtraceTable .= '';

        $messageSeparated = explode('|||', $this->message, 2);
        $messageExceptionText = $messageSeparated[0];

        $messageHashed = $messageSeparated[1];
        /** @var array|null $messageData */
        $messageData = json_decode(base64_decode($messageHashed), true);

        $messageTemplate = 'extended-exception::extended';
        if (config('app.debug') === false && ! empty($messageData['template'])) {
            $messageTemplate = $messageData['template'];
        }

        $contextFormatted = '';

        $context = $messageData['context'] ?? null;
        if (! empty($context)) {
            $contextFormatted = json_encode($context, JSON_PRETTY_PRINT);
        }

        $data = compact([
            'backtraceTable',
            'messageHashed',
            'contextFormatted',
            'context',
            'messageExceptionText',
        ]);
        if (is_array($messageData)) {
            $data = array_merge($data, $messageData);
        }

        return response()->view($messageTemplate, $data, $messageData['status'] ?? 200);
    }
}
