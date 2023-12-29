<?php

namespace App\Services;
use Intervention\Image\Facades\Image;

class service
{
    public static function uploadImage($image, $subdirectory)
    {
        if ($image) {
            $imageConverter = Image::make($image)->encode('webp', 90);
            $imageName = time() . '.webp';
            $destination = public_path('uploads/' . $subdirectory);
            $imageConverter->move($destination, $imageName);
            return $subdirectory.$imageName;
        }else{
            return null;
        }
    }

    public static function responseError($msg, $statusCode = 200)
    {
        return response()->json([
            'status' => false,
            'msg' => $msg,
        ], $statusCode);
    }

    public static function responseData($data, $msg = '')
    {
        $response = ['status' => true];
        if (!empty($msg)) {
            $response['msg'] = $msg;
        }
        $response['data'] = $data;
        return response()->json($response);
    }

    public static function responseMsg($msg)
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
        ]);
    }

}
