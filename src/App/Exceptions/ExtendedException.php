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

        $backtraceTable = '<table>';
        $backtraceTable .= '<tr><th>File</th><th>LineNumber</th><th>Class</th><th>Method</th></tr>';

        /** @var Spatie\Backtrace\Frame $backtrace */
        foreach ($backtraceSource as $backtrace) {
            $backtraceTable .= '<tr><th>'.$backtrace->file.'</th><th>'.$backtrace->lineNumber.'</th><th>'.$backtrace->class.'</th><th>'.$backtrace->method.'</th></tr>';
        }

        $backtraceTable .= '</table>';

        $messageSeparated = explode('|||', $this->message, 2);
        $messageHashed = $messageSeparated[1];
        $messageData = json_decode(base64_decode($messageHashed), true);

        $contextFormatted = json_encode($messageData['context'] ?? '', JSON_PRETTY_PRINT);

        d($messageData);

        return response()->view('extended-exception::extended', array_merge(compact([
            'backtraceTable',
            'messageHashed',
            'contextFormatted',
        ]), $messageData));
    }
}
