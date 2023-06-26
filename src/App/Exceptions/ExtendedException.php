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
        $messageHashed = $messageSeparated[1];
        /** @var array|null $messageData */
        $messageData = json_decode(base64_decode($messageHashed), true);

        $contextFormatted = '';

        if (isset($messageData['context'])) {
            $contextFormatted = json_encode($messageData['context'], JSON_PRETTY_PRINT);
        }

        $data = compact([
            'backtraceTable',
            'messageHashed',
            'contextFormatted',
        ]);
        if (is_array($messageData)) {
            $data = array_merge($data, $messageData);
        }

        return response()->view('extended-exception::extended', $data);
    }
}
