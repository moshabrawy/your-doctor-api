<?php

namespace App\Traits;

use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait FilesTrait
{

    function UploudImage($img, $path)
    {
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = uniqid() . '.' . $image_type;
        File::put(public_path() . '/uploads/images/' . $path . '/' . $file, $image_base64);
        return $file;
    }

    function UploudFiles($files, $path)
    {
        $all_files = [];
        $image_types = ['data:image/jpg;base64', 'data:image/png;base64', 'data:image/jpeg;base64'];
        if ($files) {
            foreach ($files as $file) {
                if (Str::contains($file, $image_types)) {
                    $img_type = Str::contains($file, 'data:image/jpg;base64') ? 'jpg' :
                        (Str::contains($file, 'data:image/png;base64') ? 'png' : 'jpeg');
                    $image = str_replace($image_types, '', $file);
                    $image = str_replace(' ', '+', $image);
                    $imageName = uniqid() . '.' . $img_type;
                    File::put(public_path() . '/images/' . $path . '/images/' . $imageName, base64_decode($image));
                    array_push($all_files, $imageName);
                } elseif (Str::contains($file, 'data:application/pdf;base64')) {
                    $pdf = str_replace('data:application/pdf;base64,', '', $file);
                    $pdf = str_replace(' ', '+', $pdf);
                    $pdfName = uniqid() . '.' . 'pdf';
                    File::put(public_path() . '/images/' . $path . '/pdf/' . $pdfName, base64_decode($pdf));
                    array_push($all_files, $pdfName);
                } elseif (Str::contains($file, 'data:video/mp4;base64')) {
                    $mp4 = str_replace('data:video/mp4;base64,', '', $file);
                    $mp4 = str_replace(' ', '+', $mp4);
                    $mp4Name = uniqid() . '.' . 'mp4';
                    File::put(public_path() . '/images/' . $path . '/mp4/' . $mp4Name, base64_decode($mp4));
                    array_push($all_files, $mp4Name);
                }
            }
        }
        return $all_files;
    }

    /**
     * GetFiles Function
     * Get array of files has many types
     * Resouce Used it => [TicketMasterResource - TicketReplyResource - TickeReplyResource]
     */
    function GetFiles($attachments)
    {
        $all_attachments = [];
        if ($attachments != '') {
            foreach ($attachments as $attachment) {
                $source = Str::contains($attachment, 'pdf') ? 'pdf'
                    : (Str::contains($attachment, ['jpeg', 'jpg', 'png', 'png']) ?
                        'images' : (Str::contains($attachment, 'mp4') ? 'mp4' : ''));
                $attachment = asset('/images/reply/' . $source . '/' . $attachment);
                array_push($all_attachments, $attachment);
            }
        }
        return $all_attachments;
    }
}
