<?php

namespace App\Livewire;

use App\Services\GeminiService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Smalot\PdfParser\Parser;
use Throwable;

class PdfChatbot extends Component
{
    use WithFileUploads;

    public $pdf;

    public string $question = '';

    public string $pdfText = '';

    public array $messages = [];

    public bool $processing = false;

    public function uploadPdf(): void
    {
        $this->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        try {
            $parser = new Parser();
            $document = $parser->parseFile($this->pdf->getRealPath());
            $text = trim($document->getText());

            if ($text === '') {
                $this->addError('pdf', 'No readable text was found in this PDF.');

                return;
            }

            $this->pdfText = mb_substr($text, 0, 120000);
            $this->messages = [];
            $this->question = '';

            session()->flash('status', 'PDF uploaded and parsed successfully. Ask your question below.');
        } catch (Throwable $exception) {
            $this->addError('pdf', 'Unable to parse PDF: '.$exception->getMessage());
        }
    }

    public function ask(GeminiService $gemini): void
    {
        $this->validate([
            'question' => ['required', 'string', 'min:2'],
        ]);

        if ($this->pdfText === '') {
            $this->addError('question', 'Upload a PDF first.');

            return;
        }

        $this->processing = true;

        try {
            $question = trim($this->question);
            $answer = $gemini->askWithContext($question, $this->pdfText);

            $this->messages[] = [
                'question' => $question,
                'answer' => trim($answer),
            ];

            $this->reset('question');
        } catch (Throwable $exception) {
            $this->addError('question', 'Gemini request failed: '.$exception->getMessage());
        } finally {
            $this->processing = false;
        }
    }

    public function render()
    {
        return view('livewire.pdf-chatbot');
    }
}
