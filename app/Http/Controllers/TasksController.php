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

        $sorted_tasks = $tasks_collection->sortByDesc('dependencies');

        return $sorted_tasks->values()->all();   //For testing

        $commands = $sorted_tasks->pluck('command');

        //Write commands line by line
        foreach ($commands as $command) {
            Storage::disk('public')->append($decoded_json['filename'], $command);
        }
    }
}
/*
$collection = collect([
    ['name' => 'Chair', 'colors' => ['Black']],
    ['name' => 'Desk', 'colors' => ['Black', 'Mahogany']],
    ['name' => 'Bookcase', 'colors' => ['Red', 'Beige', 'Brown']],
]);

$collection->sum(function ($product) {
    return count($product['colors']);
});
// 6
*/

