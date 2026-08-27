<?php

namespace App\Http\Controllers;

use App\Http\Resources\DatasetResource;
use App\Models\Dataset;
use Illuminate\Http\Request;

class DatasetApiController extends Controller
{
    public function getDatasets(Request $request)
    {
        $perPage = max(1, min((int) $request->query('per_page', 10), 50));
        
        $datasets = Dataset::with(['uploadBy', 'categoryData', 'typeData', 'periodeData'])->paginate($perPage);

        if ($request->query('page') > $datasets->lastPage()) {
            return response()->json([
                'status' => false,
                'message' => 'Halaman yang diminta tidak ditemukan',
                'data' => []
            ], 404);
        }

        return DatasetResource::collection($datasets)->additional([
            'status' => true,
            'message' => 'Dataset berhasil ditemukan'
        ]);
    }

    public function getDataset(Request $request, Dataset $dataset)
    {
        $dataset->load(['uploadBy', 'categoryData', 'typeData', 'periodeData']);

        return (new DatasetResource($dataset))->additional([
            'status' => true,
            'message' => 'Dataset berhasil ditemukan'
        ]);
    }
}
