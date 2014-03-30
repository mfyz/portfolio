<?php

// ie6 disable
if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== FALSE ){
	include('ie6.php');
	exit;
}

// parse portfolio
require_once('portfolio_parser.php');

// taglist html function
function taglist($taglist = false, $explode = false){
	if( !$taglist ) return false;
	if( $explode ){
		$taglist = explode(',', $taglist);
	}

	$tags = NULL;
	foreach ($taglist as $tag){
		$tag = trim($tag);
		if( $tag ){
			$tags .= '<div class="tag"><div class="start"><div class="in">'. htmlspecialchars($tag) .'</div></div></div>';
		}
	}
	if( $tags ) $tags = '<div class="tags">'. $tags .'<div class="clear"></div></div>';

	return $tags;
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Mehmet Fatih YILDIZ's Portfolio</title>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="prettyPhoto/prettyPhoto.css">
	<script src="js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="prettyPhoto/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
	<div id="header">
		<div class="text hello">
			<h1>Mehmet Fatih YILDIZ's Portfolio</h1>
			<h1>Hi!</h1>
			<h3>
				My name is Mehmet Fatih YILDIZ.<br />
				UI Designer, Web Developer and Analyst
			</h3>
		</div>
		<?php include('menu.php'); ?>
	</div>
	<div id="content">
		<div class="page_content"><div class="main_content">
			<div class="joblist">
			<?php

			foreach ($data['portfolio'] as $jobid => $job){
				if( $job['name'] && $job['name'] != 'tags' ){

					$title = htmlspecialchars($job['name']);

					// screenshots section
					$thumb_screenshot = 'images/'. $jobid .'/thumb';
					if( file_exists($thumb_screenshot.'.jpg') ) $thumb_screenshot .= '.jpg';
					else if( file_exists($thumb_screenshot.'.png') ) $thumb_screenshot .= '.png';
					else $thumb_screenshot = false;
					// content
					if( $thumb_screenshot ){
						$imagelist = array();
						for ($i=1; $i < 11; $i++){ 
							if( file_exists('images/'.$jobid.'/'. $i .'.jpg') ) $imagelist[] = 'images/'.$jobid.'/'. $i .'.jpg';
							if( file_exists('images/'.$jobid.'/'. $i .'.png') ) $imagelist[] = 'images/'.$jobid.'/'. $i .'.png';
						}
						if( $imagelist ) $jsimagelist = "['". implode("', '", $imagelist) ."']";
						else $jsimagelist = '';

						// getting file size
						list($width, $height) = getImageSize($thumb_screenshot);
						$screenshot = '
						<div class="screenshot link" id="'. $jsimagelist .'">
							<div class="frametop"><div class="framebottom" style="height: '. $height .'px;"></div></div>
							<div class="frameimage" style="height: '. $height .'px;">
								<img src="'. $thumb_screenshot .'" alt="" border="0" />
							</div>
						</div>';
					}else{
						$screenshot = '';
					}


					// description section
					$description = NULL;
					if(isset($job['year']) AND strlen($job['year']) > 0){
						$description .= '<span class="year"><b>Year :</b> '. $job['year'] .'</span>';
					}
					if(isset($job['brand']) AND strlen($job['brand']) > 0){
						if( $description ) $description .= ' <span class="sperator">//</span> ';
						$description .= '<span class="brand"><b>Brand/Client :</b> '. htmlspecialchars($job['brand']) .'</span>';
					}
					if(isset($job['agency']) AND strlen($job['agency']) > 0){
						if($description) $description .= ' <span class="sperator">//</span> ';
						$description .= '<span class="agency"><b>Agency :</b> '. htmlspecialchars($job['agency']) .'</span>';
					}
					if( $description ) $description = '<div class="description">'. $description .'</div>';


					// project url
					if(isset($job['url'])){
						$url = '<div class="url"><a href="'. $job['url'] .'" target="_blank">'. $job['url'] .'</a></div>';
					}else{
						$url = '';
					}


					// tags
					$tags = isset($job['tags']) ? taglist($job['tags'], true) : NULL;


					// final content
					print <<<EOF
					<hr size="1" class="hidden" />
					<a name="$jobid"></a>
					<div class="job $jobid">
						<div class="top"></div>
						<div class="middle">
							<h2>$title</h2>
							$screenshot
							$description
							$tags
							$url
							<div class="clear"></div>
						</div>
						<div class="bottom"></div>
					</div>
EOF;

				}
			}

			?>
			</div>
		</div></div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		
	</div>
</body>
</html>