<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    //
    function send_tasks(Request $request)
    {
        $decoded_json = json_decode($request->getContent(), true);

        //Create collection
        $tasks_collection = collect($decoded_json['tasks']);

        // Test //
        // return $tasks_collection->firstWhere('name', 'rm');
        // return $tasks_collection->all()

        $sorted_tasks = $tasks_collection->sortDesc();

        $commands = $sorted_tasks->pluck('command');

        //Dosyaya satır satır yazdır
        foreach ($commands as $command) {
            Storage::disk('public')->append($decoded_json['filename'], $command);
        }
    }
}
