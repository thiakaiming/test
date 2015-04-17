<!DOCTYPE html>
<html>
    <head>
        <title>Lab - Watermarking or framing</title>
        <style>
            dd 
            {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <form enctype="multipart/form-data" method='post' action='b.php'>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            <dl>
                <dt>
                    Original image
                </dt>
                <dd>
                    <input type="file" name="originalImage" />
                </dd>
                <dt>
                    Watermarked or framed image
                </dt>
                <dd>
                    <input type="file" name="watermarkedImage" />
                </dd>
                <dt>
                    Effect
                </dt>
                <dd>
                    <input type='radio' name='effect' value='1' checked />Watermarked&nbsp;&nbsp;
                    <input type='radio' name='effect' value='2' />Framed
                </dd>
                <dt>
                    Opacity (0 - 100)
                </dt>
                <dd>
                    <input type="text" name="opacity" />
                </dd>
                <dt>
                    If watermarked, enter the X and Y coordinates of the original image to apply the watermark image onto. <br /> 
                    If framed, enter the X and Y coordinates of framed image to apply the original image onto.
                </dt>
                <dd>
                    X <input type='text' name='x' />&nbsp;&nbsp;
                    Y <input type='text' name='y' />&nbsp;&nbsp;
                    Corner <select name="corner"><option value="1">Top Left</option><option value="2">Top Right</option><option value="3">Bottom Left</option><option value="4">Bottom Right</option></select>
                </dd>
                <br />
                <input type="submit" value="Craft" />
            </dl>
        </form>
    </body>
</html>
