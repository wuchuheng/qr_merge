<?php

namespace Wuchuheng\QrMerge;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use Endroid\QrCode\ErrorCorrectionLevel;

class QrMerge
{
    /**
     *  生成二维码
     *
     * @param $file
     * @param $x
     * @param $y
     * @param $size
     * @param $content
     * @return string
     */
    public function generateQr($file, $x, $y, $size, $content)
    {
        // 背景图路径
        // 获取背景图信息imagecreatefromstring — 从字符串中的图像流新建一图像
        $back = imagecreatefromstring(file_get_contents($file));
        list($backWidth, $backHight, $backType) = getimagesize($file); //getimagesize — 取得图像大小
        //生成二维码的函数
        $qrCode = new QrCode($content);
        $qrCode->setSize($size * 40);

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->setValidateResult(false);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setMargin($size * 0.01);

        $tmpfile = tmpfile();
        fwrite($tmpfile, $qrCode->writeString());
        $tmpfile_path = stream_get_meta_data($tmpfile)['uri'];
        // 获取二维码的图片信息
        $qrcodeImg = imagecreatefromstring($qrCode->writeString());
        list($qrcodeWidth, $qrcodeHight, $qrcodeType) = getimagesize($tmpfile_path);
        /** 背景图片合成imagecopymerge() 函数用于拷贝并合并图像的一部分
        imagecopymerge( resource dst_im, resource src_im, int dst_x, int dst_y, int src_x, int src_y, int src_w, int src_h, int pct )
        参数说明:
        dst_im 目标图像
        src_im 被拷贝的源图像
        dst_x 目标图像开始 x 坐标
        dst_y 目标图像开始 y 坐标，x,y同为 0 则从左上角开始
        src_x 拷贝图像开始 x 坐标
        src_y 拷贝图像开始 y 坐标，x,y同为 0 则从左上角开始拷贝
        src_w （从 src_x 开始）拷贝的宽度
        src_h （从 src_y 开始）拷贝的高度
        pct 图像合并程度，取值 0-100 ，当 pct=0 时，实际上什么也没做，反之完全合并
         **/
        imagecopymerge($back, $qrcodeImg, $x, $y, 0, 0, $qrcodeWidth, $qrcodeHight, 100);
        $tempFileHandle = tmpfile();
        $file_path = stream_get_meta_data($tmpfile)['uri'];
        imagepng($back,$file_path);
        imagedestroy($back);
        imagedestroy($qrcodeImg);
        $imgbinary = fread(fopen($file_path, "r"), filesize($file_path));
        return $imgbinary;
       
    }
    
    public function toBase64($imgbinary, $type)
    {
        $base64_file = 'data:image/' . $type . ';base64,' . base64_encode($imgbinary);
        return $base64_file; 
    }
    
}