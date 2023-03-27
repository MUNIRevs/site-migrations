<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GovOS Database Migration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
<?php
require_once 'config.php';
require_once 'SiteDatabase.php';

// Basic connection settings
$sourceSite = isset($_GET["source"]) ? $_GET["source"] : "thecolony";
$targetSite = isset($_GET["target"]) ? $_GET["target"] : "wm_salida";

//printf("Source = %s and target = %s.<br>", $sourceSite, $targetSite);

printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-solid fa-star"></i> Migration started for "%s" using "%s" as our source site.</div>', $targetSite, $sourceSite);

// Connect to the database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, $targetSite . "_content"); 

/*
 * Get the source ids for header, footer and HTML property.
 */
$sourceSiteDatabase = new SiteDatabase($sourceSite, $mysqli);

$sourceHeaderComponentId = $sourceSiteDatabase->getComponentId("header");
if ( $sourceHeaderComponentId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i>Could not find header component id for source site "%s".</div>', $sourceSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved header component id for source site "%s".</div>', $sourceSite);
}

$sourceFooterComponentId = $sourceSiteDatabase->getComponentId("footer");
if ( $sourceFooterComponentId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i> Could not find footer component id for source site "%s".</div>', $sourceSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved footer component id for source site "%s".</div>', $sourceSite);
}

$sourcePropertyId = $sourceSiteDatabase->getPropertyId("HTML Content");
if ( $sourcePropertyId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i> Could not find property id for source site "%s".</div>', $sourceSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved property id for source site "%s".</div>', $sourceSite);
}

/*
 * Get the target ids for header, footer and HTML property.
 */
$targetSiteDatabase = new SiteDatabase($targetSite, $mysqli);

$targetHeaderComponentId = $targetSiteDatabase->getComponentId("header");
if ( $targetHeaderComponentId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i>Could not find header component id for target site "%s".</div>', $targetSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved header component id for target site "%s".</div>', $targetSite);
}

$targetFooterComponentId = $targetSiteDatabase->getComponentId("footer");
if ( $targetFooterComponentId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i> Could not find footer component id for target site "%s".</div>', $targetSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved footer component id for target site "%s".</div>', $targetSite);
}

$targetPropertyId = $targetSiteDatabase->getPropertyId("HTML Content");
if ( $targetPropertyId == 0 ) {
    printf('<div class="alert alert-danger mt-3" role="alert"><i class="fa-solid fa-circle-xmark"></i> Could not find property id for source site "%s".</div>', $sourceSite);
} else {
    printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-sharp fa-solid fa-circle-check"></i> Retrieved property id for source site "%s".</div>', $sourceSite);
}

/*
 * Update the target header.
 */
if ( $sourceHeaderComponentId > 0 && $sourcePropertyId > 0 && $targetHeaderComponentId > 0 && $targetPropertyId > 0 ) {
    $rowsAffected = $targetSiteDatabase->updateComponentProperty($sourceSite, $sourceHeaderComponentId, $sourcePropertyId, $targetHeaderComponentId, $targetPropertyId);
}

/*
 * Update the target footer.
 */
if ( $sourceFooterComponentId > 0 && $sourcePropertyId > 0 && $targetFooterComponentId > 0 && $targetPropertyId > 0 ) {
    $rowsAffected = $targetSiteDatabase->updateComponentProperty($sourceSite, $sourceFooterComponentId, $sourcePropertyId, $targetFooterComponentId, $targetPropertyId);
}

printf('<div class="alert alert-success mt-3" role="alert"><i class="fa-solid fa-flag-checkered"></i> Database migration completed for "%s".</div>', $targetSite);
?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    </body>
</html>