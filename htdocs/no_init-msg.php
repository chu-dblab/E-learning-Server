<!--
  no_init-msg.php
   
   Copyright 2013 元兒～ <yuan@Yuan-NB>
   
-->

<?php
	/**
	 * 前置設定
	*/
	define('DOCUMENT_ROOT',dirname(__FILE__).'/');
	
?> 
<!DOCTYPE html>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8" />
		<title>尚未安裝完成</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<style>
		html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -100px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 100px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }
      
      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      #footer .container .muted {
        margin: 20px 0;
      }
		</style>
		<link href="<?php echo SITE_URL_ROOT ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
		<div id="wrap">
			<div class="container">
				<div class="page-header">
					<h1>本系統尚未建置完成</h1>
				</div>
				<p class="lead">請參考<a href="https://github.com/CHU-TDAP/E-learning-Server/blob/master/README.md">README.md</a>文件將SQL匯入，並建立config.php設定檔。</p>
			</div>
			<div id="push"></div>
		</div>
		
		<div id="footer">
			<div class="container">
				<p class="muted">CHU-TDAP on <a href="https://github.com/CHU-TDAP/">Github</a></p>
				<p class="muted credit">Template by <a href="http://martinbean.co.uk">Martin Bean</a> and <a href="http://ryanfait.com/sticky-footer/">Ryan Fait</a>.</p>
			</div>
		</div>
		
	
	<script src="<?php echo SITE_URL_ROOT ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo SITE_URL_ROOT ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		
	</script>
	</body>
</html>