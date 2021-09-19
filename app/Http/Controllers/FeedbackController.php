<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\FeedbackRequest;
use App\Mail\FeedbackMail;
use App\Models\Feedback;

/**
 * Максимально лаконичный контроллер
 */
class FeedbackController extends Controller
{
    /**
     * Метод создает новую обратную связь.
     *
     * @return \Illuminate\View\View
     */
    public function store(FeedbackRequest $request)
    {
        $validated = $request->validated();
        $feedback = Feedback::create($validated);
        $mailTo = env('DIRECTOR_EMAIL');
        if ($mailTo) {
            Mail::to($mailTo)
                ->send(new FeedbackMail($feedback));
        }
        return true;
    }
}
