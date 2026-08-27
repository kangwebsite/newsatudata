<?php

use Livewire\Component;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    public $dataset;
    public $excelStyles;
    public $excelTable;

    public function mount()
    {
        $file = strtoupper(pathinfo($this->dataset->file, PATHINFO_EXTENSION));

        if (in_array($file, ['XLSX', 'XLS', 'CSV'])) {
            $this->renderExcel();
        }
    }

    public function renderExcel()
    {
        $path = Storage::path($this->dataset->file);
        
        $reader = IOFactory::createReaderForFile($path);
        
        $filter = new class implements IReadFilter {
            public function readCell($columnAddress, $row, $worksheetName = '') {
                return $row <= 15;
            }
        };
        
        $reader->setReadFilter($filter);
        $spreadsheet = $reader->load($path);
        
        $writer = new Html($spreadsheet);
        $writer->generateStyles(true);
        $rawHtml = $writer->generateHTMLAll();

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($rawHtml);
        libxml_clear_errors();

        $styleNode = $dom->getElementsByTagName('style')->item(0);
        $this->excelStyles = $styleNode ? $styleNode->nodeValue : '';

        $tableNode = $dom->getElementsByTagName('table')->item(0);
        $this->excelTable = $tableNode ? $dom->saveHTML($tableNode) : '';
    }
};
?>

<div>
    

    @if($excelTable)
        <div class="w-full overflow-hidden bg-white [&_table]:w-max! [&_table]:min-w-full! [&_table]:border-collapse! [&_td]:border! [&_td]:border-slate-200! [&_td]:px-4! [&_td]:py-2! [&_td]:text-sm! [&_td]:text-slate-700! [&_th]:border! [&_th]:border-slate-200! [&_th]:px-4! [&_th]:py-2! [&_th]:text-sm! [&_th]:text-slate-700! [&_th]:bg-slate-50!">
            {!! $excelTable !!}
        </div>
    @else
        <div class="p-4 text-sm text-amber-800 rounded-lg bg-amber-50 border border-amber-200">
            Pratinjau tidak tersedia untuk format file ini.
        </div>
    @endif
</div>