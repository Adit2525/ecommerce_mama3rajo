<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Preview CSV import (validate rows without committing)
     */
    public function previewCSV(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $file = $request->file('file');
        $lines = file($file->getRealPath());
        $data = [];
        $errors = [];

        foreach ($lines as $i => $line) {
            if ($i === 0) continue; // Skip header
            $row = str_getcsv(trim($line));
            if (count($row) < 3) {
                $errors[$i] = 'Invalid row format';
                continue;
            }

            $data[$i] = [
                'sku' => $row[0] ?? null,
                'name' => $row[1] ?? null,
                'price' => floatval($row[2] ?? 0),
                'raw_row' => $i,
            ];

            // Validate each field
            if (!$data[$i]['name']) {
                $errors[$i] = 'Name is required';
            }
            if ($data[$i]['price'] <= 0) {
                $errors[$i] = 'Price must be > 0';
            }
        }

        return response()->json([
            'preview' => $data,
            'errors' => $errors,
            'total_rows' => count($lines) - 1,
            'valid_rows' => count($data) - count($errors),
        ]);
    }

    /**
     * Commit CSV import (within a transaction; rollback on error)
     */
    public function commitCSV(Request $request)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->input('data') as $row) {
                    \App\Models\Product::create([
                        'sku' => $row['sku'] ?? null,
                        'name' => $row['name'],
                        'price' => $row['price'],
                    ]);
                }
            });

            return response()->json(['success' => 'Products imported']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
