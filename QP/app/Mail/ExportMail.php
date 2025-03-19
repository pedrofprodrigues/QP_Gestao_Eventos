<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fileName;
    public $filePath;

    public function __construct($fileName, $filePath)
    {
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject('Exportação de Eventos')
                    ->view('emails.export')
                    ->attach($this->filePath, [
                        'as' => $this->fileName,
                        'mime' => 'text/csv',
                    ]);
    }

}
