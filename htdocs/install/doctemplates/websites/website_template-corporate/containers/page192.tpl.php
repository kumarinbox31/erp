<?php // BEGIN PHP
$websitekey=basename(__DIR__); if (empty($websitepagefile)) $websitepagefile=__FILE__;
if (! defined('USEDOLIBARRSERVER') && ! defined('USEDOLIBARREDITOR')) {
	$pathdepth = count(explode('/', $_SERVER['SCRIPT_NAME'])) - 2;
	require_once ($pathdepth ? str_repeat('../', $pathdepth) : './').'master.inc.php';
} // Not already loaded
require_once DOL_DOCUMENT_ROOT.'/core/lib/website.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/website.inc.php';
ob_start();
// END PHP ?>
<html lang="en">
<head>
<title>Pricing</title>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="pricing" />
<meta name="title" content="Pricing" />
<meta name="description" content="All the prices of our offers" />
<meta name="generator" content="Dolibarr 17.0.0-alpha (https://www.pairbytes.com)" />
<meta name="dolibarr:pageid" content="192" />
<?php if ($website->use_manifest) { print '<link rel="manifest" href="/manifest.json.php" />'."\n"; } ?>
<!-- Include link to CSS file -->
<link rel="stylesheet" href="/styles.css.php?website=<?php echo $websitekey; ?>" type="text/css" />
<!-- Include link to JS file -->
<script async src="/javascript.js.php"></script>
<!-- Include HTML header from common file -->
<?php if (file_exists(DOL_DATA_ROOT."/website/".$websitekey."/htmlheader.html")) include DOL_DATA_ROOT."/website/".$websitekey."/htmlheader.html"; ?>
<!-- Include HTML header from page header block -->

</head>
<!-- File generated by Dolibarr website module editor -->
<body id="bodywebsite" class="bodywebsite bodywebpage-pricing">
<div class="page">

    <?php includeContainer('header'); ?>

      <section id="sectionimage" contenteditable="true">
        <div class="">
          <div class="swiper-wrapper text-center" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
            <div class="swiper-slide swiper-slide-active" style="height: 200px; background-image: url('medias/image/template-corporate/background_sunset.webp'); background-size: cover;">
              <div class="swiper-slide-caption">
                <div class="container">
                  <div class="row justify-content-sm-center">
                    <div class="col-md-11 col-lg-10">
                      <div class="text-white text-uppercase jumbotron-custom border-modern fadeInUp animated" data-caption-animate="fadeInUp" data-caption-delay="0s">Our plans</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </section>




      <!-- Our plans -->
      <section id="sectionplans" contenteditable="true" class="section-67 section-md-top-50 section-md-bottom-75">
        <div class="container">
            <div id="carousel-plans-month" class="" data-interval="0" style="margin-top:50px">
                    <!-- begin .carousel-inner -->
                    <div class="pricing-plan-slider" role="listbox">
                        <!-- begin .item -->
                        <div class="item active">
                            <!-- begin .container -->
                            <div class="container">

                                <!-- begin .row -->
                                <div class="plan-list flex-box row spacer-bottom-sm flexwrap_inherit">
                                    <!-- begin .plan-item -->
                                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-12 box">
                                            <div class="plan-tile"> 
                                                <div class="plan-box-header"></div>
                                                <div class="plan-title">FREE</div>
                                                <div class="plan-tag">The best choice for personal use</div>
                                                <div class="plan-feat"><span class="summaryplan">The service 1 for free</div>
                                                <div class="plan-pricer">
                                                    <span class="plan-price" id="monthly_plan_37"><span><sup></sup>0<sup>€</sup></span>/ month</span>
                                                </div>
                                                <div class="plan-features">
                                                    <span class="plan-features-title">Available features are :</span>                                                                                                        </span>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <i class="fa fa-check"></i>
                                                            Service 1                                                            
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="plan-btn plan-picker">
                                                    <a href="plan-a.php" class="btn btn-rect btn-primary d-block d-md-inline-block" id="plana">Subcribe</a>
                                                </div>
                                            </div>  
                                    </div>
                                    <!-- end .plan-item -->
                                    
                                    <!-- begin .plan-item -->
                                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-12 box ">                      
                                            <div class="plan-tile"> 
                                                <div class="plan-box-header"></div>
                                                <div class="plan-title">STARTER</div>
                                                <div class="plan-tag">For small companiess</div>
                                                <div class="plan-feat">The service 1 and product 1 at low price</div>
                                                <div class="plan-pricer">
                                                    <span class="plan-price" id="starter"><span><sup></sup>29<sup>€</sup></span>/ month</span>
                                                </div>
                                                <div class="plan-features">
                                                    <span class="plan-features-title">Available features are :</span>                                                                                                        </span>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <i class="fa fa-check"></i>
                                                            Service 1
                                                        </li>
                                                        <li>
                                                        	<i class="fa fa-check"></i>
                                                        	Product 1
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="plan-btn plan-picker">
                                                    <a href="plan-b.php" class="btn btn-rect btn-primary d-block d-md-inline-block" id="planb">Subscribe</a>
                                                </div>
                                            </div>  
                                    </div>
                                    <!-- end .plan-item -->
                                    
                                    <!-- Most popular plan box -->
                                    <div class="col-lg-15 col-md-4 col-sm-6 col-xs-12 box most-popular-plan-box2 most-popular-plan-box ">                  
                                        <div class="plan-tile">
                                            <div class="plan-box-header" id="default"></div> 
                                                <div class="plan-title">PREMIUM</div>
                                                <div class="plan-tag">For large companies</div>
                                                <div class="plan-feat">The full option package for a one shot price
                                                </div>
                                                <div class="plan-pricer">
                                                    <span class="plan-price planPremiumPrice" id="premium"><span><sup></sup>2499<sup>€</sup></span></span>
                                                </div>
                                                <div class="plan-features">
                                                    <span class="plan-features-title">Available features are :</span>
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <i class="fa fa-check"></i> 
                                                            Service 1                                                        </li>
                                                        <li id="higherFeature" class="hide">
                                                            <i class="fa fa-check"></i> 
                                                            Service 2                                                        </li>
                                                        <li>
                                                            <i class="fa fa-check"></i> 
                                                            Product 1                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="plan-btn plan-picker">
                                                    <a href="planc.php" class="btn btn-rect btn-primary d-block d-md-inline-block maincolorbisbackground" id="planc">Buy</a>
                                                </div>
                                            </div>  
                                    </div>
                                    <!-- Ends // Most Popular Plan Box --> 
                                </div>
                                <!-- end .row -->
                            </div>
                            <!-- end .container -->
                        </div>
                        <!-- end .item -->
                    </div>
                    <!-- end .row -->
                <!-- end .carousel -->          
            </div>
        </div>
      </section>
      
      
        
    <br><br>

    <?php includeContainer('footer'); ?>

</div>
    

</body>
</html>
<?php // BEGIN PHP
$tmp = ob_get_contents(); ob_end_clean(); dolWebsiteOutput($tmp, "html", 192);
// END PHP ?>
