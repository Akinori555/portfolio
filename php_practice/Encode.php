<?php
function e(string $str, string $charset = 'UTF-8'): string {
  $enc = mb_detect_encoding($str);
  $str = mb_convert_encoding($str, $charset, $enc);
  return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, $charset);
}