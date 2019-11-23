<?PHP
// header('Access-Control-Allow-Origin: *');
// $content = file_get_contents("https://detail.1688.com/offer/577969755086.html");

// var_dump($content);

// echo file_get_contents("https://detail.1688.com/offer/577969755086.html");


crawl_page("https://detail.1688.com/offer/577969755086.html", 1);

function crawl_page($url, $depth = 5)
{
    static $seen = array();
    if (isset($seen[$url]) || $depth === 0) {
        return;
    }

    $seen[$url] = true;

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);

    $anchors = $dom->getElementsByTagName('a');
    foreach ($anchors as $element) {
        $href = $element->getAttribute('href');
        if (0 !== strpos($href, 'http')) {
            $path = '/' . ltrim($href, '/');
            if (extension_loaded('http')) {
                $href = http_build_url($url, array('path' => $path));
            } else {
                $parts = parse_url($url);
                $href = $parts['scheme'] . '://';
                if (isset($parts['user']) && isset($parts['pass'])) {
                    $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                }
                $href .= $parts['host'];
                if (isset($parts['port'])) {
                    $href .= ':' . $parts['port'];
                }
                $href .= dirname($parts['path'], 1).$path;
            }
        }
        crawl_page($href, $depth - 1);
    }
    echo "URL:",$url,PHP_EOL,"CONTENT:",PHP_EOL,$dom->saveHTML(),PHP_EOL,PHP_EOL;
}

?>
<!-- <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>load demo</title>
  <style>
  body {
    font-size: 12px;
    font-family: Arial;
  }
  </style>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>

<script type="text/javascript">

	$(document).ready(function(){
		// $.ajax({ // start before dom is ready
		// 	url: 'https://shopmein.net/qs/',
		// 	type: 'get',
		// 	dataType: 'text/html',
		// 	success: function(data) {
		// 		console.log(data);
		// 	}
		// });
		crawl_page("https://shopmein.net/qs/", 2);
	});
	
	
</script>
<div id="content">

	</div>
</body>
</html> -->
