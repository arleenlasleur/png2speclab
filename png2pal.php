<?php
if('cli'!==PHP_SAPI) return;
echo "PNG to SpecLab palette preset conv, v. 0.1, (c) Arleen Lasleur 2020".PHP_EOL;
if(!isset($argv[1])){
  echo "CALL: png2pal <file.png>".PHP_EOL;
  echo "Bitmap should be at least 256px wide.".PHP_EOL;
  return;
}

$im = imagecreatefrompng($argv[1]);
$outn=str_replace(".png",".pal",$argv[1]);
echo "File: ".$outn.PHP_EOL;

$fp=fopen($outn,"w+");

fwrite($fp,"[ColorPaletteHeader]".PHP_EOL);
fwrite($fp,"palVersion=768".PHP_EOL);
fwrite($fp,"palNumEntries=256".PHP_EOL);
fwrite($fp,"[Colors]".PHP_EOL);

for($i=0;$i<256;$i++){
  $rgb = imagecolorat($im,$i,0);
  $r = ($rgb >> 16) & 0xFF;
  $g = ($rgb >> 8) & 0xFF;
  $b = $rgb & 0xFF;
  $lzr=$r<16; $lzr=$lzr?"0":"";
  $lzg=$g<16; $lzg=$lzg?"0":"";
  $lzb=$b<16; $lzb=$lzb?"0":"";
  fwrite($fp,"Color".$i."=00".strtoupper($lzb.dechex($b).$lzg.dechex($g).$lzr.dechex($r)).PHP_EOL);
}

fclose($fp);
?>
