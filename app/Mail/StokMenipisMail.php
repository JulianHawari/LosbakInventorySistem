<?php

namespace App\Mail;

use App\Models\BahanBaku;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StokMenipisMail extends Mailable
{
    use Queueable, SerializesModels;

    public BahanBaku $bahan;

    public function __construct(BahanBaku $bahan)
    {
        $this->bahan = $bahan;
    }

    public function build()
    {
        return $this
            ->subject('⚠️ Stok Bahan Baku Menipis')
            ->view('emails.stok-menipis');
    }
}
