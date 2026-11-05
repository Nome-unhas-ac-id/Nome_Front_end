<?php

namespace App\Services;

use App\Models\Memo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Html;
use Symfony\Component\HttpFoundation\Response;

class MemoExport
{
    public function download(Memo $memo, string $type): Response
    {
        $filename = (Str::slug($memo->title) ?: 'notulen').'.'.$type;
        if ($type === 'pdf') {
            return Pdf::loadView('exports.memo', ['memo' => $memo, 'summary' => SummaryHtml::clean($memo->summary_text)])
                ->setOptions(['isRemoteEnabled' => false, 'isPhpEnabled' => false, 'defaultFont' => 'DejaVu Sans'])
                ->download($filename)->header('Cache-Control', 'private, no-store');
        }
        Settings::setOutputEscapingEnabled(true);
        $document = new PhpWord;
        $document->setDefaultFontName('Arial');
        $section = $document->addSection();
        $section->addTitle($memo->title, 1);
        foreach ([
            'Tanggal' => $memo->meeting_date->format('Y-m-d'), 'Waktu (WITA)' => $memo->meeting_time,
            'Selesai (WITA)' => $memo->meeting_end_time, 'Lokasi' => $memo->location,
            'Pimpinan' => $memo->leader_name, 'Notulis' => $memo->notetaker_name, 'Agenda' => $memo->agenda,
        ] as $label => $value) {
            $section->addText($label.': '.($value ?: '-'));
        }
        $section->addTitle('Ringkasan', 2);
        Html::addHtml($section, SummaryHtml::xhtml($memo->summary_text ?? ''), false, false);
        $section->addTitle('Daftar Hadir', 2);
        foreach ($memo->attendees ?? [] as $index => $person) {
            $section->addText(($index + 1).'. '.$person['name'].' — '.($person['agency_or_position'] ?? ''));
        }
        if ($memo->letter) {
            $section->addPageBreak();
            $section->addTitle('Surat Pengantar', 1);
            foreach ($memo->letter as $key => $value) {
                if ($value) {
                    $section->addText(str_replace('_', ' ', ucfirst($key)).': '.$value);
                }
            }
        }

        return response()->streamDownload(fn () => IOFactory::createWriter($document, 'Word2007')->save('php://output'), $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Cache-Control' => 'private, no-store',
        ]);
    }
}
