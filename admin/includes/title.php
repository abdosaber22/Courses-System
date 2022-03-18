<?php

  function title() {
    global $page_title;
    if (isset($page_title)) {
      echo $page_title;
    }
  }
