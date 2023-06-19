<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\User;
use App\Services\CsvProcessor;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function process(CsvUploadRequest $request)
    {
        try {
            $uploadedCsvFile = $request->file('file-upload');
            $csvProcessor = new CsvProcessor($uploadedCsvFile);
            $dbData = $csvProcessor->getFormattedData();

            User::insert($dbData);

            return redirect(route('csv.processed'));

        } catch (\Exception $exception) {
            Log::error('Exception thrown during file processing : ' . $exception->getMessage());
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function complete()
    {

        return view('complete')->with([
            'count' => User::all()->count()
        ]);
    }
}
