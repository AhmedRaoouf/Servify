<?php

namespace App\Helpers;
use Intervention\Image\Image;

class helper
{
    public static function uploadImage($image, $subdirectory, $prefix = '')
    {

        if ($image) {
            $ext = $image->getClientOriginalExtension();
            $imageName = $prefix . time() . '.' . $ext;
            $destination = public_path('uploads/' . $subdirectory);
            $image->move($destination, $imageName);
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
