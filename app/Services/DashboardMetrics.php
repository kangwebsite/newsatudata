<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardMetrics
{
    /**
     * Umur cache metrik dashboard. Nilai ringan seperti ini tidak perlu
     * dihitung ulang di setiap request/Livewire roundtrip.
     */
    private const TTL_SECONDS = 60;

    /**
     * Semua key cache metrik (dipakai untuk invalidasi).
     *
     * @var array<int, string>
     */
    private const CACHE_KEYS = [
        'dashboard:summary',
        'dashboard:monthly-datasets',
        'dashboard:top-skpd',
        'dashboard:type-distribution',
    ];

    /**
     * Ringkasan angka utama untuk kartu statistik.
     *
     * @return array{datasets: int, approved: int, skpd: int, users: int, bps: int, admin: int, posts: int}
     */
    public static function summary(): array
    {
        return Cache::remember('dashboard:summary', self::TTL_SECONDS, function (): array {
            // Dua agregat dalam satu query: total + yang disetujui/published.
            $datasets = DB::table('datasets')
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN status IN ('approved', 'published') THEN 1 ELSE 0 END) as approved")
                ->first();

            $roles = DB::table('users')
                ->select('role', DB::raw('COUNT(*) as total'))
                ->groupBy('role')
                ->pluck('total', 'role');

            return [
                'datasets' => (int) ($datasets->total ?? 0),
                'approved' => (int) ($datasets->approved ?? 0),
                'skpd' => (int) ($roles['user'] ?? 0),
                'users' => (int) $roles->sum(),
                'bps' => (int) ($roles['bps'] ?? 0),
                'admin' => (int) ($roles['admin'] ?? 0),
                'posts' => DB::table('posts')->count(),
            ];
        });
    }

    /**
     * Jumlah dataset yang diunggah per bulan untuk N bulan terakhir
     * (termasuk bulan berjalan, bulan tanpa data tetap ditampilkan sebagai 0).
     *
     * @return array<int, array{label: string, total: int}>
     */
    public static function monthlyDatasetCounts(int $months = 12): array
    {
        return Cache::remember('dashboard:monthly-datasets:' . $months, self::TTL_SECONDS, function () use ($months): array {
            $expression = DB::connection()->getDriverName() === 'sqlite'
                ? "strftime('%Y-%m', created_at)"
                : "DATE_FORMAT(created_at, '%Y-%m')";

            $counts = DB::table('datasets')
                ->selectRaw("{$expression} as period, COUNT(*) as total")
                ->whereNotNull('created_at')
                ->groupByRaw($expression)
                ->pluck('total', 'period');

            $shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $start = now()->startOfMonth()->subMonths($months - 1);

            $result = [];

            for ($i = 0; $i < $months; $i++) {
                $date = $start->copy()->addMonths($i);

                $result[] = [
                    'label' => $shortMonths[$date->month - 1] . ' ' . $date->year,
                    'total' => (int) ($counts[$date->format('Y-m')] ?? 0),
                ];
            }

            return $result;
        });
    }

    /**
     * SKPD (user role "user") dengan jumlah dataset terbanyak.
     *
     * @return array<int, array{name: string, total: int}>
     */
    public static function topSkpd(int $limit = 10): array
    {
        return Cache::remember('dashboard:top-skpd:' . $limit, self::TTL_SECONDS, function () use ($limit): array {
            return DB::table('datasets')
                ->join('users', 'users.id', '=', 'datasets.upload_by')
                ->where('users.role', 'user')
                ->select('users.name', DB::raw('COUNT(datasets.id) as total'))
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('total')
                ->orderBy('users.name')
                ->limit($limit)
                ->get()
                ->map(fn ($row): array => [
                    'name' => (string) $row->name,
                    'total' => (int) $row->total,
                ])
                ->all();
        });
    }

    /**
     * Distribusi dataset per tipe data, termasuk warna & persentase.
     *
     * @return array<int, array{name: string, total: int, color: string, percentage: int}>
     */
    public static function typeDistribution(): array
    {
        return Cache::remember('dashboard:type-distribution', self::TTL_SECONDS, function (): array {
            $rows = DB::table('type_data')
                ->leftJoin('datasets', 'datasets.type_data_id', '=', 'type_data.id')
                ->select('type_data.name', 'type_data.color', DB::raw('COUNT(datasets.id) as total'))
                ->groupBy('type_data.id', 'type_data.name', 'type_data.color')
                ->orderByDesc('total')
                ->get();

            $total = max(1, (int) $rows->sum('total'));

            $fallbackColors = ['#0f766e', '#0ea5e9', '#f59e0b', '#8b5cf6', '#ef4444', '#64748b'];

            return $rows
                ->values()
                ->map(fn ($row, int $index): array => [
                    'name' => (string) $row->name,
                    'total' => (int) $row->total,
                    'color' => $row->color ?: $fallbackColors[$index % count($fallbackColors)],
                    'percentage' => (int) round(((int) $row->total / $total) * 100),
                ])
                ->all();
        });
    }

    /**
     * Buang cache metrik, dipanggil saat data sumber berubah.
     */
    public static function flush(): void
    {
        foreach (self::CACHE_KEYS as $key) {
            Cache::forget($key);

            // Key dengan suffix (mis. dashboard:monthly-datasets:12) ikut dibersihkan.
            foreach ([6, 12, 24, 5, 10, 15] as $suffix) {
                Cache::forget($key . ':' . $suffix);
            }
        }
    }
}
