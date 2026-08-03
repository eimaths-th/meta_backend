<?php

namespace App\Http\Controllers;

use App\Models\EmailAuditLog;
use App\Models\FormManage;
use App\Models\ReceiptForm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EmailAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = $this->applyFilters(ReceiptForm::query(), $request);

        $summary = [
            'total' => (clone $baseQuery)->count(),
            'sent' => (clone $baseQuery)->whereHas('emailAudits', function (Builder $query) {
                $query->whereIn('action', ['send', 'resend']);
            })->count(),
            'without_send_log' => (clone $baseQuery)->whereDoesntHave('emailAudits', function (Builder $query) {
                $query->whereIn('action', ['send', 'resend']);
            })->count(),
        ];

        $query = clone $baseQuery;

        if ($request->input('status') === 'sent') {
            $query->whereHas('emailAudits', function (Builder $auditQuery) {
                $auditQuery->whereIn('action', ['send', 'resend']);
            });
        } elseif ($request->input('status') === 'not_sent') {
            $query->whereDoesntHave('emailAudits', function (Builder $auditQuery) {
                $auditQuery->whereIn('action', ['send', 'resend']);
            });
        }

        $forms = $query
            ->with(['emailAudits' => function ($auditQuery) {
                $auditQuery->latest('created_at');
            }, 'formManage'])
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        $forms->getCollection()->transform(function (ReceiptForm $form) {
            $audits = $form->emailAudits;
            $sendAudit = $audits->first(function (EmailAuditLog $audit) {
                return in_array($audit->action, ['send', 'resend'], true);
            });

            $form->setAttribute('latest_email_audit', $audits->first());
            $form->setAttribute('last_email_send_audit', $sendAudit);

            return $form;
        });

        return view('admin.email_audit_logs.index', [
            'forms' => $forms,
            'summary' => $summary,
            'formManages' => FormManage::query()
                ->orderBy('form_name')
                ->get(['sfield', 'form_name']),
            'actions' => EmailAuditLog::query()
                ->select('action')
                ->distinct()
                ->orderBy('action')
                ->pluck('action'),
        ]);
    }

    private function applyFilters(Builder $query, Request $request): Builder
    {
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function (Builder $formQuery) use ($search) {
                $formQuery
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        if ($request->filled('sfield')) {
            $query->where('sfield', $request->input('sfield'));
        }

        if ($request->filled('action')) {
            $action = $request->input('action');
            $query->whereHas('emailAudits', function (Builder $auditQuery) use ($action) {
                $auditQuery->where('action', $action);
            });
        }

        if ($request->filled('from')) {
            $query->whereDate('submission_date', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('submission_date', '<=', $request->input('to'));
        }

        return $query;
    }
}
