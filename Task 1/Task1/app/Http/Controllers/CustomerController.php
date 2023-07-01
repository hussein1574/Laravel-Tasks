<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use App\Jobs\UploadCsvProcess;
use App\Models\Customer;

class CustomerController extends Controller
{
        public function upload(Request $request)
    {
        if (request()->has('mycsv')) {
            $data   =   file(request()->mycsv);

            $header = [];

            $data = array_map('str_getcsv', $data);

            $header = $data[0];
            unset($data[0]);

            dispatch(new UploadCSVProcess($data, $header));

            return response()->json([
                'status' => 'success',
                'result' => 'The file is being processed in the background.',
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'result' => 'Please upload a CSV file',
        ], 400);
    }
}