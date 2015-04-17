<?php 
    if ((isset($_FILES['originalImage'])) && (isset($_FILES['watermarkedImage'])))
    {
        $effect = getPostValue('effect', 1);
        $opacity = getPostValue('opacity', 50);
        $x = getPostValue('x', 0);
        $y = getPostValue('y', 0);
        $corner = getPostValue('corner', 1);
        
        if ($effect == '1') //watermarked; source will be watermarkedImage and destination will be originalImage
        {
            list($srcWidth, $srcHeight) = getimagesize($_FILES['watermarkedImage']['tmp_name']);
            $srcPath = $_FILES['watermarkedImage']['tmp_name'];
            $srcType = $_FILES['watermarkedImage']['type'];
            
            list($dstWidth, $dstHeight) = getimagesize($_FILES['originalImage']['tmp_name']);
            $dstPath = $_FILES['originalImage']['tmp_name'];
            $dstType = $_FILES['originalImage']['type'];
        }
        else    //framed; source will be originalImage and destination will be watermarkedImage
        {
            list($srcWidth, $srcHeight) = getimagesize($_FILES['originalImage']['tmp_name']);
            $srcPath = $_FILES['originalImage']['tmp_name'];
            $srcType = $_FILES['originalImage']['type'];
            
            list($dstWidth, $dstHeight) = getimagesize($_FILES['watermarkedImage']['tmp_name']);
            $dstPath = $_FILES['watermarkedImage']['tmp_name'];
            $dstType = $_FILES['watermarkedImage']['type'];
        }
        
        $srcImage = createImage($srcPath, $srcType);
        $dstImage = createImage($dstPath, $dstType);
        
        if ($srcImage && $dstImage)
        {
            switch ($corner)
            {
                case 1: //top left
                    imagecopymerge($dstImage, $srcImage, $x, $y, 0, 0, $srcWidth, $srcHeight, $opacity);
                    break;
                case 2: //top right
                    imagecopymerge($dstImage, $srcImage, ($dstWidth - 1 - $x - $srcWidth), $y, 0, 0, $srcWidth, $srcHeight, $opacity);
                    break;
                case 3: //bottom left
                    imagecopymerge($dstImage, $srcImage, $x, ($dstHeight - 1 - $y - $srcHeight), 0, 0, $srcWidth, $srcHeight, $opacity);
                    break;
                case 4: //bottom right
                    imagecopymerge($dstImage, $srcImage, ($dstWidth - 1 - $x - $srcWidth), ($dstHeight - 1 - $y - $srcHeight), 0, 0, $srcWidth, $srcHeight, $opacity);
                    break;
                default:
                    throw new Exception('Corner unidentified.');
            }
            
            $rawData = getImageRawData($dstImage, $dstType);
            
            imagedestroy($srcImage);
            imagedestroy($dstImage);
        }
    }
?>

<a href="a.php">Back to crafting</a><br />
<?php if (isset($rawData)):?>
<img src="data:<?=$dstType?>;base64,<?= base64_encode($rawData) ?>" style="border-width: 1px; border-color: black; border-style: solid;" />
<?php else: ?>
No image
<?php endif;?>

<?php 
    function getPostValue($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }
    
    function createImage($path, $type)
    {
        switch (strtolower($type))
        {
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            default:
                return null;
        }
    }
    
    function getImageRawData($image, $type)
    {
        ob_start(); //enable output buffer
        
        switch ($type)
        {
            case 'image/gif':
                imagegif($image);
                break;
            case 'image/jpeg':
                imagejpeg($image);
                break;
            case 'image/png':
                imagepng($image);
                break;
            default:
                imagegd($image);
        }
        
        return ob_get_clean();   //get output buffer content
    }
?>