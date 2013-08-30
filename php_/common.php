<?php

/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$service_url = "https://www.google.com/hosted/services/v1.0/reports/ReportingData";

/**
 * Uses libcurl to execute an HTTP POST to the specified
 * URL, containing the specified POST document.
 */
function ExecutePost($post_url, $post_document) {

  /* Create a cURL handle. */
  $ch = curl_init();
  
  /* Set cURL options. */
  curl_setopt($ch, CURLOPT_URL, $post_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_document);
 
  $result = curl_exec($ch);  /* Execute the HTTP request. */
  curl_close($ch);           /* Close the cURL handle. */

  return $result;
}

?>
