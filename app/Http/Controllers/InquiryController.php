<?php

namespace App\Http\Controllers;

use App\Enums\Locale;
use App\Enums\SitePage;
use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Services\InquiryNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Throwable;

class InquiryController extends Controller
{
    /**
     * Store a quote request and notify the business.
     *
     * Success is only reported once the inquiry has been saved; email
     * delivery problems are handled by the notifier without failing the request.
     */
    public function store(StoreInquiryRequest $request, InquiryNotifier $notifier): RedirectResponse
    {
        $contactPage = SitePage::Contact->routeName(Locale::current());

        try {
            $inquiry = Inquiry::create($request->inquiryAttributes());
        } catch (Throwable $exception) {
            // Database exceptions embed the query bindings (the customer's personal data), so only safe details are logged.
            Log::error('A quote request could not be saved.', [
                'exception' => $exception::class,
                'code' => $exception->getCode(),
            ]);

            return to_route($contactPage)->withErrors([
                'form' => __('contact.errors.not_saved', ['phone' => config('business.phone_display')]),
            ]);
        }

        $notifier->notify($inquiry);

        Inertia::flash('inquiry', 'received');

        return to_route($contactPage);
    }
}
