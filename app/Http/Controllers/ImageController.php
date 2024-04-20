<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadimage(ImageRequest $request): PromiseInterface|Response
    {
        $photo=fopen($request->file('file'),'rb');
        $response=Http::attach('file',$photo)->post('http://127.0.0.1.5000/predict');
        fclose($photo);
        return $response;
    }
}
