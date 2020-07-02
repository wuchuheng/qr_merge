<h1 align="center"> qr_merge </h1>

<p align="center"> 二维码背景图片合并.</p>


## Installing

```shell
$ composer require wuchuheng/qr_merge -vvv
```

## Usage

``` php 
include_once  './vendor/autoload.php';

use Wuchuheng\QrMerge\QrMerge;
$QrMerge = new QrMerge();
$backgroud_file = './test.png';
$x = 100,
$y = 100,
$size = 3;
$qr_content = 'hello world';
$imgbinary = $QrMerge->generateQr($backgroud_file, $x, $y, $size, $qr_content);
$pngBase64 = $QrMerge->toBase64($imgbinary, 'png');
var_dump($pngBase64); // data:image/png;base64,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
```
![](./generate.png)

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/wuchuheng/qr_merge/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/wuchuheng/qr_merge/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT