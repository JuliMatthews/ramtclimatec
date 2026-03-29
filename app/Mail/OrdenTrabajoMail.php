<?php

namespace App\Mail;

use App\Models\OrdenTrabajo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class OrdenTrabajoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OrdenTrabajo $ot) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Orden de Trabajo #" . str_pad($this->ot->id, 4, '0', STR_PAD_LEFT) . " - Ramtclimatec",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orden_trabajo',
        );
    }

    public function attachments(): array
    {
        $ot = $this->ot;
        $ot->load(['cliente', 'direccion', 'tecnicos', 'ayudantes', 'materiales.material']);

        $pdf = Pdf::loadView('pdf.orden_trabajo', compact('ot'))
            ->setPaper('a4', 'portrait');

        return [
            Attachment::fromData(
                fn() => $pdf->output(),
                "OT-" . str_pad($ot->id, 4, '0', STR_PAD_LEFT) . ".pdf"
            )->withMime('application/pdf'),
        ];
    }
}