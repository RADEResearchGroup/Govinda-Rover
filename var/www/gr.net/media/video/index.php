<?php
	//Start Sesi User
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/common.php');	
	//Sertakan fungsi user
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/user.php');
	//Sertakan file text antarmuka
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/lang.php');
	//Sertakan fungsi updater.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/updater.php');
	//Sertakan fungsi display.php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/display.php');
	//Sertakan fungsi gallery
	require_once($_SERVER['DOCUMENT_ROOT'] . '/media/video/video.php');
	
	
		
//Cek apakah yang meminta akses adalah user
//yang memiliki cukup hak akses
if(user_check_login(1)) :

	//Set judul halaman
	$title = $text[88] . " | " . $text[3];
	//Sertakan file header
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/header.php');
?>


<?php print display_print_page_wrapper_top();?>
	<div id="pesan" class="alert alert-success" role="alert"></div>
    <!-- The container for the list of example images -->
	<ul class="nav nav-tabs" role="tablist">
	  <li><a href="/media/foto"><?php print $text[82];?></a></li>
	  <li class="active"><a href="#"><?php print $text[83];?></a></li>
	</ul>
	<div class="panel panel-default" style="margin-top:20px;">
	  <div class="panel-heading"><?php print $text[85];?></div>
	  <div class="panel-body">
		<video id="pemutar_1" class="video-js vjs-default-skin" controls preload="none" width="100%" height="264"
		  poster="/media/poster.jpg"
		  data-setup="{}">
		<source id="sumber-video" src="#" type='video/mp4' />
		<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
		</video>
				<?php sfpg_javascript();?>
	  </div>
	</div>	
<?php print display_print_page_wrapper_bottom();?>
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation and button states -->
<script src="/js/jquery.blueimp-gallery.min.js"></script>
<script src="/js/bootstrap-image-gallery.js"></script>

<?php 
	//Sertakan file footer
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/footer.php');
endif;?>