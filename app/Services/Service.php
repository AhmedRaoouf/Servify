<?php

namespace App\Services;
use Intervention\Image\Facades\Image;

class Service
{
    public static function uploadImage($image, $subdirectory)
    {
        if ($image) {
            $img = Image::make($image->getRealPath());
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $destinationPath = public_path('uploads/' . $subdirectory);
            $imageName = uniqid() . '.webp';
            $img->encode('webp', 80)->save($destinationPath . '/' . $imageName);

            return $subdirectory . $imageName;
        }

        return null;
    }


    public static function responseError($msg, $statusCode)
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

    public static function responseMsg($msg,$statusCode=200)
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
        ],$statusCode);
    }

}
