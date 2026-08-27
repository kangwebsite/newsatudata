<?php

use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    public $dataset;
    public $chartLabels = [];
    public $chartSeries = [];
    public $hasChartData = false;

    public function mount()
    {
        $file = strtoupper(pathinfo($this->dataset->file, PATHINFO_EXTENSION));

        if (in_array($file, ['XLSX', 'XLS', 'CSV'])) {
            $this->extractChartData();
        }
    }

    public function extractChartData()
    {
        $path = Storage::path($this->dataset->file);
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $rows = $worksheet->toArray();
        $labels = [];
        $series = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            if ($index > 15) {
                break;
            }

            if (isset($row[0]) && isset($row[1]) && is_numeric($row[1])) {
                $labels[] = (string) $row[0];
                $series[] = (float) $row[1];
            }
        }

        if (count($labels) > 0) {
            $this->chartLabels = $labels;
            $this->chartSeries = $series;
            $this->hasChartData = true;
        }
    }
};
?>

<div>
    @if($hasChartData)
        <div class="mt-8 bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Pratinjau Grafik</h3>
            
            <div 
                x-data="excelVisualizer()" 
                x-init="initChart()"
                class="w-full"
            >
                <div x-ref="chartContainer"></div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('excelVisualizer', () => ({
                    labels: @entangle('chartLabels'),
                    seriesData: @entangle('chartSeries'),
                    
                    initChart() {
                        let options = {
                            chart: {
                                type: 'bar',
                                height: 350,
                                fontFamily: 'inherit',
                                toolbar: { show: false }
                            },
                            series: [{
                                name: 'Nilai',
                                data: this.seriesData
                            }],
                            xaxis: {
                                categories: this.labels,
                                labels: {
                                    style: { colors: '#64748b' }
                                }
                            },
                            colors: ['#0ea5e9'],
                            plotOptions: {
                                bar: { borderRadius: 4 }
                            }
                        };

                        let chart = new ApexCharts(this.$refs.chartContainer, options);
                        chart.render();
                    }
                }));
            });
        </script>
    @endif
</div>