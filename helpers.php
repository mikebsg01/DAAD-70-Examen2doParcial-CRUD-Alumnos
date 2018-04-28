<?php

if (! function_exists('dd')) {
  function dd($something) {
    echo "<pre class=\"pre\">{$something}</pre>";
  }
}