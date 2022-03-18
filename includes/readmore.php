<?php

  function readMoreFunction($story_desc, $link, $targetFile, $id) {
    $chars = 950;
    $story_desc = substr($story_desc,0,$chars);
    $story_desc = substr($story_desc,0,strrpos($story_desc,' '));
    $story_desc = $story_desc." <a class='read-more' href='$link?$targetFile=$id'>قراءة المزيد ...</a>";
    return $story_desc;
  }
