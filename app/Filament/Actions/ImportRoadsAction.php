<?php

namespace App\Filament\Actions;

use App\Models\Road;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use InvalidArgumentException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;
use Throwable;
use ZipArchive;

class ImportRoadsAction extends Action
{
    /**
     * Kolom yang wajib ada pada header file.
     *
     * @var array<int, string>
     */
    protected const REQUIRED_COLUMNS = ['name', 'type', 'lat_a', 'lng_a'];

    /**
     * Alias header yang diterima, supaya file dari Excel (Indonesia/Inggris)
     * tetap terbaca tanpa harus mengganti nama kolom.
     *
     * @var array<string, array<int, string>>
     */
    protected const HEADER_ALIASES = [
        'name' => ['name', 'nama', 'nama_jalan', 'jalan'],
        'type' => ['type', 'tipe', 'kategori', 'kategori_jalan'],
        'warna' => ['warna', 'color', 'colour', 'warna_hex', 'hex'],
        'lat_a' => ['lat_a', 'latitude_a', 'lintang_a', 'lat1', 'lat_awal', 'latitude_1'],
        'lng_a' => ['lng_a', 'lon_a', 'long_a', 'longitude_a', 'bujur_a', 'lng1', 'lon1', 'long1'],
        'lat_b' => ['lat_b', 'latitude_b', 'lintang_b', 'lat2', 'lat_akhir', 'latitude_2'],
        'lng_b' => ['lng_b', 'lon_b', 'long_b', 'longitude_b', 'bujur_b', 'lng2', 'lon2', 'long2'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Import Excel / CSV')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->color('gray')
            ->modalHeading('Import data jalan')
            ->modalDescription('Unggah file .xlsx, .xls, atau .csv. Baris pertama harus berisi nama kolom: name, type, warna, lat_a, lng_a, lat_b, lng_b.')
            ->modalSubmitActionLabel('Import')
            ->schema([
                FileUpload::make('file')
                    ->label('File Excel atau CSV')
                    ->acceptedFileTypes([
                        'text/csv',
                        'text/x-csv',
                        'application/csv',
                        'application/x-csv',
                        'text/comma-separated-values',
                        'text/x-comma-separated-values',
                        'text/plain',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/zip',
                        'application/x-zip',
                        'application/x-zip-compressed',
                        'application/x-ole-storage',
                        'application/CDFV2',
                        'application/octet-stream',
                    ])
                    ->maxSize(2048)
                    ->storeFiles(false)
                    ->required()
                    ->helperText('Kolom: name, type, warna, lat_a, lng_a, lat_b, lng_b. Contoh: Jalan Lintas Sumatra | nasional | #0f766e | -4.4447 | 104.5126 | -4.4465 | 104.5155. Baris dengan nama jalan yang sama akan diperbarui. Maksimal 2 MB.'),
            ])
            ->action(function (array $data): void {
                $file = $data['file'] ?? null;

                if (is_array($file)) {
                    $file = reset($file);
                }

                if (! $file instanceof TemporaryUploadedFile) {
                    Notification::make()
                        ->title('File tidak terbaca')
                        ->body('Silakan unggah ulang file Excel atau CSV.')
                        ->danger()
                        ->send();

                    return;
                }

                $this->importFile($file);
            });
    }

    protected function importFile(TemporaryUploadedFile $file): void
    {
        try {
            $rows = $this->readRows($file);
        } catch (Throwable $exception) {
            Notification::make()
                ->title('Gagal membaca file')
                ->body($exception->getMessage())
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        if ($rows === []) {
            Notification::make()
                ->title('File kosong')
                ->body('Tidak ada baris data yang bisa dibaca.')
                ->danger()
                ->send();

            return;
        }

        $header = array_shift($rows);
        $map = $this->mapHeader(is_array($header) ? $header : []);

        $missing = array_diff(self::REQUIRED_COLUMNS, array_keys($map));

        if ($missing !== []) {
            Notification::make()
                ->title('Kolom wajib tidak ditemukan')
                ->body('Kolom yang belum ada: ' . implode(', ', $missing) . '. Baris pertama file harus berisi nama kolom.')
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        $created = 0;
        $updated = 0;
        $failed = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $lineNumber = $index + 2;

            if (! is_array($row) || $this->isBlankRow($row)) {
                continue;
            }

            try {
                $payload = $this->buildPayload($row, $map);

                $road = Road::firstOrNew(['name' => $payload['name']]);
                $isNew = ! $road->exists;

                $road->fill([
                    'name' => $payload['name'],
                    'type' => $payload['type'],
                    'warna' => $payload['warna'],
                    'path_coordinates' => $payload['path_coordinates'],
                ])->save();

                $isNew ? $created++ : $updated++;
            } catch (Throwable $exception) {
                $failed++;

                if (count($errors) < 8) {
                    $errors[] = "Baris {$lineNumber}: " . $exception->getMessage();
                }
            }
        }

        $lines = ["{$created} data baru, {$updated} diperbarui, {$failed} gagal."];

        if ($errors !== []) {
            foreach ($errors as $error) {
                $lines[] = e($error);
            }

            if ($failed > count($errors)) {
                $lines[] = '… dan ' . ($failed - count($errors)) . ' baris lainnya.';
            }
        }

        $notification = Notification::make()
            ->title('Import selesai')
            ->body(implode('<br>', $lines))
            ->persistent();

        if (method_exists($livewire = $this->getLivewire(), 'resetTable')) {
            $livewire->resetTable();
        }

        if ($failed > 0) {
            ($created + $updated) > 0 ? $notification->warning() : $notification->danger();
        } else {
            $notification->success();
        }

        $notification->send();
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function readRows(TemporaryUploadedFile $file): array
    {
        $path = $file->getRealPath();

        if ($path === false || ! is_file($path)) {
            throw new RuntimeException('File unggahan tidak ditemukan.');
        }

        $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

        if (in_array($extension, ['xlsx', 'xls'], true)) {
            return $this->readSpreadsheet($path);
        }

        return $this->readCsv($path);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function readSpreadsheet(string $path): array
    {
        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException(
                'Ekstensi PHP "zip" belum aktif, jadi file Excel tidak bisa dibaca. ' .
                'Simpan file sebagai CSV, atau aktifkan "extension=zip" di php.ini lalu restart server.'
            );
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        $spreadsheet->disconnectWorksheets();

        return array_values($rows);
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    protected function readCsv(string $path): array
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new RuntimeException('File CSV tidak bisa dibaca.');
        }

        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content) ?? $content;

        if (! mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }

        $delimiter = $this->detectDelimiter($content);

        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $content);
        rewind($handle);

        $rows = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = $row;
        }

        fclose($handle);

        // Jika delimiter adalah koma tapi koordinat pakai koma sebagai pemisah desimal
        // (format Indonesia), field seperti -4.393,250 akan terpecah jadi -4.393 dan 250.
        // Gabungkan kembali field-field yang terpecah sehingga jumlah kolom cocok dengan header.
        if (! empty($rows)) {
            $expectedCols = count($rows[0]);
            $rows = array_map(fn (array $row): array => $this->mergeSplitFields($row, $expectedCols), $rows);
        }

        return $rows;
    }

    /**
     * Deteksi delimiter CSV yang paling sesuai. Coba koma, titik koma, dan tab,
     * pilih yang menghasilkan jumlah kolom paling konsisten di semua baris.
     */
    protected function detectDelimiter(string $content): string
    {
        $lines = array_filter(explode("\n", $content), fn ($line): bool => trim($line) !== '');

        if (empty($lines)) {
            return ',';
        }

        $headerLine = $lines[0] ?? '';

        $bestDelimiter = ',';
        $bestScore = -1.0;

        foreach ([',', ';', "\t"] as $candidate) {
            $headerCols = count(str_getcsv($headerLine, $candidate));

            if ($headerCols < 2) {
                continue;
            }

            $matchingRows = 0;
            $totalRows = 0;

            foreach ($lines as $line) {
                $totalRows++;
                $cols = count(str_getcsv($line, $candidate));

                if ($cols === $headerCols) {
                    $matchingRows++;
                }
            }

            $score = $totalRows > 0 ? $matchingRows / $totalRows : 0.0;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestDelimiter = $candidate;
            }
        }

        return $bestDelimiter;
    }

    /**
     * Gabungkan field-field yang terpecah karena koma desimal (format Indonesia)
     * dianggap sebagai delimiter CSV.
     *
     * Contoh: [-4.393, 250, 104.413.000] -> [-4.393250, 104413000]
     *
     * @param  array<int, mixed>  $row
     * @param  int  $expectedCols
     * @return array<int, mixed>
     */
    protected function mergeSplitFields(array $row, int $expectedCols): array
    {
        if (count($row) <= $expectedCols) {
            return $row;
        }

        $result = [];
        $i = 0;

        while ($i < count($row)) {
            $current = (string) $row[$i];

            // Coba gabungkan dengan field berikutnya jika hasilnya adalah angka valid
            if ($i + 1 < count($row) && count($result) + 2 <= $expectedCols) {
                $merged = $current . (string) $row[$i + 1];

                if (is_numeric($merged)) {
                    $result[] = $merged;
                    $i += 2;

                    continue;
                }
            }

            $result[] = $current;
            $i++;
        }

        return $result;
    }

    /**
     * @param  array<int, mixed>  $header
     * @return array<string, int>
     */
    protected function mapHeader(array $header): array
    {
        $map = [];

        foreach ($header as $index => $label) {
            $key = $this->normalizeHeader($label);

            if ($key === '') {
                continue;
            }

            foreach (self::HEADER_ALIASES as $column => $aliases) {
                if (! isset($map[$column]) && in_array($key, $aliases, true)) {
                    $map[$column] = $index;

                    break;
                }
            }
        }

        return $map;
    }

    protected function normalizeHeader(mixed $label): string
    {
        $label = str_replace("\xEF\xBB\xBF", '', (string) $label);
        $label = strtolower(trim($label));
        $label = preg_replace('/[^a-z0-9]+/', '_', $label) ?? $label;

        return trim($label, '_');
    }

    /**
     * @param  array<int, mixed>  $row
     */
    protected function isBlankRow(array $row): bool
    {
        foreach ($row as $value) {
            if (filled($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array<int, mixed>  $row
     * @param  array<string, int>  $map
     * @return array{name: string, type: string, warna: string, path_coordinates: array<int, array<int, float>>}
     */
    protected function buildPayload(array $row, array $map): array
    {
        $name = trim((string) $this->valueAt($row, $map, 'name'));

        if ($name === '') {
            throw new InvalidArgumentException('nama jalan kosong.');
        }

        $type = $this->normalizeType($this->valueAt($row, $map, 'type'));

        if ($type === null) {
            throw new InvalidArgumentException(
                "kategori '{$this->valueAt($row, $map, 'type')}' tidak dikenali. Gunakan nasional, provinsi, atau kabupaten."
            );
        }

        $warna = $this->normalizeColor($this->valueAt($row, $map, 'warna'));

        if (! preg_match('/^#[0-9a-f]{6}$/', $warna)) {
            throw new InvalidArgumentException("warna '{$warna}' bukan kode hex 6 digit (contoh: #0f766e).");
        }

        $latA = $this->toCoordinate($this->valueAt($row, $map, 'lat_a'), 'latitude A', 90);
        $lngA = $this->toCoordinate($this->valueAt($row, $map, 'lng_a'), 'longitude A', 180);

        $points = [[$latA, $lngA]];

        $latB = $this->toCoordinate($this->valueAt($row, $map, 'lat_b'), 'latitude B', 90, required: false);
        $lngB = $this->toCoordinate($this->valueAt($row, $map, 'lng_b'), 'longitude B', 180, required: false);

        if (($latB === null) !== ($lngB === null)) {
            throw new InvalidArgumentException('latitude B dan longitude B harus diisi bersamaan atau dikosongkan keduanya.');
        }

        if ($latB !== null && $lngB !== null) {
            $points[] = [$latB, $lngB];
        }

        return [
            'name' => $name,
            'type' => $type,
            'warna' => $warna,
            'path_coordinates' => $points,
        ];
    }

    /**
     * @param  array<int, mixed>  $row
     * @param  array<string, int>  $map
     */
    protected function valueAt(array $row, array $map, string $column): mixed
    {
        if (! isset($map[$column])) {
            return null;
        }

        return $row[$map[$column]] ?? null;
    }

    protected function normalizeType(mixed $value): ?string
    {
        $normalized = strtolower(trim((string) $value));
        $normalized = preg_replace('/[\s_-]+/', ' ', $normalized) ?? $normalized;
        $normalized = trim($normalized);

        return match ($normalized) {
            '', 'null', '0' => null,
            'nasional', 'jalan nasional', 'national', 'n' => 'jalan_nasional',
            'provinsi', 'jalan provinsi', 'provincial', 'p' => 'jalan_provinsi',
            'kabupaten', 'jalan kabupaten', 'district', 'k' => 'jalan_kabupaten',
            default => null,
        };
    }

    protected function normalizeColor(mixed $value): string
    {
        $color = strtolower(trim((string) $value));

        if ($color === '') {
            return '#0f766e';
        }

        return str_starts_with($color, '#') ? $color : '#' . $color;
    }

    protected function toCoordinate(mixed $value, string $label, float $limit, bool $required = true): ?float
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === null || $value === '') {
            if ($required) {
                throw new InvalidArgumentException("{$label} wajib diisi.");
            }

            return null;
        }

        $original = (string) $value;

        // Format Indonesia: titik = pemisah ribuan, koma = pemisah desimal.
        // Strategi: ganti koma jadi titik, lalu sisakan hanya titik pertama (desimal),
        // hapus titik berikutnya (pemisah ribuan).
        // Contoh: -4.393,250 -> -4.393.250 -> -4.393250
        // Contoh: 104.413.000 -> 104.413000
        $idn = str_replace(',', '.', $original);
        $firstDot = strpos($idn, '.');
        if ($firstDot !== false) {
            $idn = substr($idn, 0, $firstDot + 1) . str_replace('.', '', substr($idn, $firstDot + 1));
        }

        $candidates = [];

        // 1. Format Indonesia sudah diproses di atas
        if (is_numeric($idn)) {
            $candidates[] = (float) $idn;
        }

        // 2. Langsung (format standar, misal: -4.4447)
        if (is_numeric($original)) {
            $candidates[] = (float) $original;
        }

        // 3. Ganti koma dengan titik saja (misal: -4,393 -> -4.393)
        $cd = str_replace(',', '.', $original);
        if (is_numeric($cd)) {
            $candidates[] = (float) $cd;
        }

        // 4. Hapus koma saja (misal: -4.393,250 -> -4.393250)
        $nc = str_replace(',', '', $original);
        if (is_numeric($nc)) {
            $candidates[] = (float) $nc;
        }

        // Pilih kandidat pertama yang berada dalam rentang valid
        foreach ($candidates as $candidate) {
            if (abs($candidate) <= $limit) {
                return $candidate;
            }
        }

        throw new InvalidArgumentException("{$label} '{$original}' bukan angka.");
    }
}