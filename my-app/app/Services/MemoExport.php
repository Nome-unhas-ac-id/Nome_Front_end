<?php

namespace App\Services;

use App\Models\Memo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MemoExport
{
    public function download(Memo $memo, string $type): Response
    {
        $filename = (Str::slug($memo->title) ?: 'notulen').'.'.$type;
        return Pdf::loadView('exports.memo', ['memo' => $memo, 'summary' => SummaryHtml::clean($memo->summary_text)])
            ->setOptions(['isRemoteEnabled' => false, 'isPhpEnabled' => false, 'defaultFont' => 'DejaVu Sans'])
            ->download($filename)->header('Cache-Control', 'private, no-store');
    }
}
