<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::match(['get', 'post'], '/filemanager', function (Request $request) {
    require_once base_path('public/RichFilemanager/connectors/php/events.php');

    function fm_authenticate()
    {
        // Customize this code as desired.
        return true;
    }

    function fm_has_read_permission($filepath)
    {
        // Customize this code as desired.
        return true;
    }

    function fm_has_write_permission($filepath)
    {
        // Customize this code as desired.
        return true;
    }


    $config = [];

    // example to override the default config
    $config = [
       'security' => [
           'extensions' => [
               'restrictions' => [
                    "jpg",
                    "jpe",
                    "jpeg",
                    "gif",
                    "png",
                    "svg",
                    "txt",
                    "pdf",
                    "odp",
                    "ods",
                    "odt",
                    "rtf",
                    "doc",
                    "docx",
                    "xls",
                    "xlsx",
                    "ppt",
                    "pptx",
                    "csv",
                    "ogv",
                    "avi",
                    "mkv",
                    "mp4",
                    "webm",
                    "m4v",
                    "ogg",
                    "mp3",
                    "wav",
                    "zip",
                    "md",
                    "html",
                    "js",
                    "css",
                    "svg",
                    "fcp",
                    "otf",
                    "woff",
                    "ttf",
                    "eot"
               ],
           ],
       ],
    ];


    $app = new \RFM\Application();

    // uncomment to use events
    $app->registerEventsListeners();

    $local = new \RFM\Repository\Local\Storage($config);

    // example to setup files root folder
    $path = storage_path().'/app';
    $local->setRoot($path, true, false);

    $app->setStorage($local);

    // set application API
    $app->api = new RFM\Api\LocalApi();

    $app->run();
});
