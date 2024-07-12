<?php // BEGIN PHP
$websitekey=basename(__DIR__); if (empty($websitepagefile)) $websitepagefile=__FILE__;
if (! defined('USEDOLIBARRSERVER') && ! defined('USEDOLIBARREDITOR')) {
	$pathdepth = count(explode('/', $_SERVER['SCRIPT_NAME'])) - 2;
	require_once $pathdepth ? str_repeat('../', $pathdepth) : './'.'master.inc.php';
} // Not already loaded
require_once DOL_DOCUMENT_ROOT.'/core/lib/website.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/website.inc.php';
ob_start();
// END PHP ?>
<html lang="en">
<head>
<title>index</title>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="" />
<meta name="title" content="index" />
<meta name="description" content="" />
<meta name="generator" content="Dolibarr 17.0.0-alpha (https://www.pairbytes.com)" />
<meta name="dolibarr:pageid" content="148" />
<?php if ($website->use_manifest) { print '<link rel="manifest" href="/manifest.json.php" />'."\n"; } ?>
<!-- Include link to CSS file -->
<link rel="stylesheet" href="/styles.css.php?website=<?php echo $websitekey; ?>" type="text/css" />
<!-- Include link to JS file -->
<script async src="/javascript.js.php"></script>
<!-- Include HTML header from common file -->
<?php if (file_exists(DOL_DATA_ROOT."/website/".$websitekey."/htmlheader.html")) include DOL_DATA_ROOT."/website/".$websitekey."/htmlheader.html"; ?>
<!-- Include HTML header from page header block -->
<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		 <!-- Font Awesome -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet"> 
		<script
			src="https://kit.fontawesome.com/14273d579a.js"
			crossorigin="anonymous"
		></script>

	 
		<title>Template</title>
	</head>
</head>
<!-- File generated by Dolibarr website module editor -->
<body id="bodywebsite" class="bodywebsite bodywebpage-index">
<!-- Enter here your HTML content. Add a section with an id tag and tag contenteditable="true" if you want to use the inline editor for the content  -->
<section id="mysection1" contenteditable="true">
	<section id="main">
			<div class="container text-center">
				<div class="row">
					<div class="col-md-6">
						<div class="jumbotron gy-3">
							<h1 class="display-4">Our company</h1>
							<p class="lead">
								Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum excepturi ipsa consequatur accusamus eveniet dignissimos necessitatibus provident dolore cupiditate.
							</p>
							<hr class="my-4" />
							<p>
								It uses utility classes for typography and spacing to space content out within the
								larger container.
							</p>
							<p class="lead">
								<a  href="#" role="button" onclick="alert('Please edit the website page to define the URL you want the link to point to...')">
									<button class="btn btn-perso btn-md">
									PRE ORDER NOW
									</button>
								</a>
								<a  href="#contact" role="button">
									<button class="btn btn-perso2 btn-md mx-3">
									CONTACT US
									</button>
								</a>    
							</p>
						</div>
					</div>
					<div class="col-md-6">
						<img src="/image/template02/bg.webp" alt="landingpage" width="100%">
					</div>
			</div>
			<hr />
		</section>
		 
		<section class="products-section text-center container">
			<div class="row">
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>
				<div class="col-md-6 product">
					<div>
						<div class="bg">
							<img
								src="/image/template02/icon.webp"
								class="card-img-top img-fluid"                                                                
								alt="..."
								style="width: 30%; height: 50%;"
							/>
							<div class="card-body">
								<h2 class="card-title">LoremIpsum</h2>
								<p class="card-text">
									Some quick example text to build on the
									card title and make up the bulk of the
									card's content.
								</p>
								 
							</div>
						</div>                                                
					</div>
				</div>                
		</section>
		<hr />
		<section>
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12 flex">
						<h1>UNLIMITED FOR ALL</h1>
						<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minus molestias voluptatibus voluptatem Lorem ipsum dolor, sit amet consectetur adipisicing elit. Veritatis officia voluptatem incidunt tempore esse porro sequi eveniet eum corrupti quo.</p>
						<div class="card text-dark bg-dark m-5 text-start" style="max-width: 18rem;">
							<div class="card-header">
								<p class="text-secondary"><span class="fs-1 text-white">$79</span>/month</p>                                
							</div>                            
							<div class="card-body flex">
								<p class="card-text">WHAT YOU WILL GET</p>                                
								<p> <i class="fa fa-chevron-right marginrightonly"></i> Lorem ipsum dolor sit, amet consectetur </p> <br/>
								<p> <i class="fa fa-chevron-right marginrightonly"></i> Lorem ipsum dolor sit, amet consectetur </p> <br/>
								<p> <i class="fa fa-chevron-right marginrightonly"></i> Lorem ipsum dolor sit, amet consectetur </p> <br/>
								<a  href="#" role="button">
									<button class="btn btn-perso btn-md">
									PRE ORDER NOW
									</button>
								</a>
							</div>
						</div>    
					</div>
				</div>
			</div>
		</section> 
		<hr />
		<section id="contact">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12 flex">
							<h1>Contact us</h1>
							<section id="sectionfooterdolibarr" contenteditable="true" class="footerdolibarr">
								<div style="margin: 50px; text-align: center">
									<span class="fa fa-envelope-o"></span> <?php echo $mysoc->email ?><br>
									<span class="fa fa-address-card-o"></span> <?php echo $mysoc->getFullAddress() ?><br>
								</div>
							</section>
					 
							<!-- Google MAPS -->
							<center><div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo urlencode($mysoc->getFullAddress()); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
							</div>
							<style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px; border-radius: 15px;}</style>
							</div></center>
					 
						<br><br><br>

					</div>
				</div>
			</div>
		</section> 
		<hr />
		<footer class="bg text-center text-white">
			<!-- Grid container -->
			<div class="container p-4 pb-0">
			  <!-- Section: Social media -->
			  <section class="mb-4">
				<?php foreach ($mysoc->socialnetworks as $key => $value) {
					print '<a class="btn btn-perso2 btn-floating m-1" href="'. (preg_match('/^http/', $value) ? $value : 'https://www.'.$key.'.com/'.$value).'"><span class="fab fa-'.$key.'"></i></a>';
				} ?>

			  </section>
			  <!-- Section: Social media -->
			</div>
			<!-- Grid container -->
		   
			<!-- Copyright -->
			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
			  © 2022 Dolibarr:
			  <a class="text-white" href="https://dolicloud.com/">Dolicloud.com</a>
			</div>
			<!-- Copyright -->
		  </footer>
</section>

</body>
</html>
<?php // BEGIN PHP
$tmp = ob_get_contents(); ob_end_clean(); dolWebsiteOutput($tmp, "html", 148);
// END PHP ?>
