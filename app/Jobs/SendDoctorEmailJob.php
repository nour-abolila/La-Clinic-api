<?php

namespace App\Jobs;

use App\Mail\DoctorMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDoctorEmailJob implements ShouldQueue
{
    use Queueable;

    protected User $user;
    protected string $generatedPassword;

    public function __construct(User $user, string $generatedPassword)
    {
        $this->user = $user;
        $this->generatedPassword = $generatedPassword;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new DoctorMail($this->user, $this->generatedPassword));
    }
}
