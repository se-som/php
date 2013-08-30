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

/**
 * This sample code demonstrates how to utilize the Google Apps
 * PHP Client Library to retrieve reports. It is intended to help you
 * get started on using the client library and the Reporting API.
 */

/* Include Google Apps PHP client library */
require_once("report.php");
require_once("auth.php");

/* Include navigation menu */
require_once("navigation.php");

/* Set the default page to home */
$page = "home";
if ( $_GET['page'] ) {
  $page = $_GET['page'];
}

/* Do not show result page when the page is first loaded */
$show_result = FALSE;

$mytoken = '';
if ( $_GET['token'] ) {
  $mytoken = $_GET['token'];
}

$mydomain = '';
if ( $_GET['domain'] ) {
  $mydomain = $_GET['domain'];
}

$header = '';

$error = '';

/* Process Get Token request */
if ( isset($_POST['GetToken']) ) {
  $mydomain = $_POST['admin_domain'] ;
  $result = GetAuthToken($_POST['admin_email'], $_POST['admin_password'],
                        "", "");
  $header = "Your token:";
  /* If an error is detected, show the error, not the result page */
  if ((!stristr($result, "Error")) &&
     (!stristr($result, "Authentication failed"))) {
    $mytoken = $result;
    $show_result = TRUE;
  }
  else {
    $error = $result;
  }
}

/* Process Retrieve Report Request */
if ( isset($_POST['GetReport']) ) {
  $reportdate = $_POST['date_year'] . '-' . $_POST['date_month'] .
      '-' . $_POST['date_day'];
  switch ( $_POST['report_type'] ) {
    case 'accounts':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "accounts", "Accounts");
      $show_result = TRUE;
      break;
    case 'activity':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "activity", "Activity");
      $show_result = TRUE;
      break;
    case 'disk_space':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "disk_space", "Disk Space");
      $show_result = TRUE;
      break;
    case 'email_clients':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "email_clients", "Email Clients");
      $show_result = TRUE;
      break;
    case 'quota_limit':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "quota_limit_accounts", "Quota Limit");
      $show_result = TRUE;
      break;
    case 'summary':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "summary", "Summary");
      $show_result = TRUE;
      break;
    case 'suspended':
      $result = RetrieveReport($mytoken, $mydomain, $reportdate,
          "suspended_accounts", "Suspended Accounts");
      $show_result = TRUE;
      break;
    case '':
      $result = "Please select a valid report type";
      $show_result = TRUE;
  }
}

?>
<html>
<head>
<title>My Reporting Panel - <?php echo($page); ?></title>
<?php echo NavigationCss(); ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
</head>
<body>
<table cellspacing="0" cellpadding="5" width="800">
<tr>
  <td width="80%" valign="top">
    <?php if ( $page != "home" && $error == '' ) {
      PageNavigation($page, $mydomain, $mytoken);
    }
    ?>
  </td>
</tr>
<tr>
  <td width="80%" valign="top">
   <?php if ( ($page == "home" && $show_result == FALSE) || $error != '' ) { ?>
    <table class="btable">
    <tr>
      <td bgcolor="dddfff"><h3>My Reporting Panel</h3></td>
    </tr>
    <tr>
      <td>
This is a demo of the Google Apps Reporting API.
      <hr>
      <form action="reportingdemo.php?page=token" method="post">
      <table>
      <tr>
        <td>Domain Name:</td>
        <td><input type="text" size="20" maxlength="50" name="admin_domain"></td>
      </tr>
      <tr>
        <td>Admin Email address:</td>
        <td><input type="text" size="20" maxlength="30" name="admin_email"></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" size="15" maxlength="20" name="admin_password">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" name="GetToken" value="Get Token">
        </td>
      </tr>
      </table>
      </form>
      </td>
    </tr>
    </table>
    <?php echo $error ?>
    <?php } ?>

    <?php if ( $page == "get_report" && $show_result == FALSE &&
               $mytoken != '' && $mydomain != '') { ?>
    <form action="reportingdemo.php?page=get_report
   &token=<?php echo $mytoken ?>&domain=<?php echo $mydomain ?>" method="post">
    <table>
    <tr>
      <td colspan=2><b>Get Reports on Your Domain</b></td>
    </tr>
    <tr>
      <td>Desired Report Date:</td>
      <td><input type="text" size="4" maxlength="4" name="date_year"> YYYY -
          <input type="text" size="2" maxlength="2" name="date_month"> MM -
          <input type="text" size="2" maxlength="2" name="date_day"> DD</td>
    </tr>
    <tr>
      <td>Report Type:</td>
      <td><select tabindex=1 name="report_type">
            <option value="">--Select--</option>
            <option value="accounts">Accounts Report</option>
            <option value="activity">Activity Report</option>
            <option value="disk_space">Disk Space Report</option>
            <option value="email_clients">Email Clients Report</option>
            <option value="quota_limit">Quota Limit Report</option>
            <option value="summary">Summary Report</option>
            <option value="suspended">Suspended Accounts Report</option>
          </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="GetReport" value="Get Report">
      </td>
    </tr>
    </table>
    </form>
    <?php } ?>

    <?php if ( $show_result ) {
            if ( $header != '' ) {   ?>
            <p><b><?php echo $header ?></b></p>
         <?php } ?>
    <pre>
    <?php echo $result; ?>
    </pre>
    <?php } ?>
  </td>
</tr>
</table>
</body>
</html>
