<!DOCTYPE html>
<html>
<head>
	  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="author" content="kitsoft">
    <link rel="icon" href="http://127.0.0.1/polaris/assets/img/favicon.ico">
    <!-- Custom styles for this template -->
    <link href="http://127.0.0.1/polaris/assets/css/estilo.css" rel="stylesheet">
     <!-- Bootstrap core CSS -->
    <link href="http://127.0.0.1/polaris/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
	<link type="text/css" rel="stylesheet" href="http://127.0.0.1/polaris/assets/image_crud/css/fineuploader.css" />
	<link type="text/css" rel="stylesheet" href="http://127.0.0.1/polaris/assets/image_crud/css/photogallery.css" />
	<link type="text/css" rel="stylesheet" href="http://127.0.0.1/polaris/assets/image_crud/css/colorbox.css" />
	<script src="http://127.0.0.1/polaris/assets/image_crud/js/jquery-1.8.2.min.js"></script>
	<script src="http://127.0.0.1/polaris/assets/image_crud/js/jquery-ui-1.9.0.custom.min.js"></script>
	<script src="http://127.0.0.1/polaris/assets/image_crud/js/fineuploader-3.2.min.js"></script>
	<script src="http://127.0.0.1/polaris/assets/image_crud/js/jquery.colorbox-min.js"></script>
</head>
<body>

	

<div class="container ">	


		<script>
$(function(){
			createUploader();
			loadColorbox();
});
function loadColorbox()
{
	$('.color-box').colorbox({
		rel: 'color-box'
	});
}
function loadPhotoGallery(){
	$.ajax({
		url: 'http://127.0.0.1/polaris/admin/diapositivas/ajax_list',
		cache: false,
		dataType: 'text',
		beforeSend: function()
		{
			$('.file-upload-messages-container:first').show();
			$('.file-upload-message').html("Cargando por favor espere...");
		},
		complete: function()
		{
			$('.file-upload-messages-container').hide();
			$('.file-upload-message').html('');
		},
		success: function(data){
			$('#ajax-list').html(data);
			loadColorbox();
		}
	});
}

function createUploader() {
	var uploader = new qq.FineUploader({
		element: document.getElementById('fine-uploader'),
		request: {
			 endpoint: 'http://127.0.0.1/polaris/admin/diapositivas/upload_file'
		},
		validation: {
			 allowedExtensions: ['jpeg', 'jpg', 'png', 'gif']
		},		
		callbacks: {
			 onComplete: function(id, fileName, responseJSON) {
				 loadPhotoGallery();
			 }
		},
		debug: true,
		/*template: '<div class="qq-uploader">' +
			'<div class="qq-upload-drop-area"><span>Arrastre los archivos aquí para subirlos</span></div>' +
			'<div class="qq-upload-button">Subir sus archivos aquí</div>' +
			'<ul class="qq-upload-list"></ul>' +
			'</div>',
		fileTemplate: '<li>' +
			'<span class="qq-upload-file"></span>' +
			'<span class="qq-upload-spinner"></span>' +
			'<span class="qq-upload-size"></span>' +
			'<a class="qq-upload-cancel" href="#">Se ha Cancelado</a>' +
			'<span class="qq-upload-failed-text">Ha fallado</span>' +
			'</li>',
*/
	});
}

function saveTitle(data_id, data_title)
{
	  	$.ajax({
			url: 'http://127.0.0.1/polaris/admin/diapositivas/insert_title',
			type: 'post',
			data: {primary_key: data_id, value: data_title},
			beforeSend: function()
			{
				$('.file-upload-messages-container:first').show();
				$('.file-upload-message').html("Guardando título...");
			},
			complete: function()
			{
				$('.file-upload-messages-container').hide();
				$('.file-upload-message').html('');
			}
			});
}

window.onload = createUploader;

</script>
<!-- <div id="file-uploader-demo1" class="floatL upload-button-container"></div>
<div class="file-upload-messages-container hidden">
	<div class="message-loading"></div>
	<div class="file-upload-message"></div>
	<div class="clear"></div>
</div>-->
<div id="fine-uploader"></div>
<div class="clear"></div>
<div id='ajax-list'>
		<script type='text/javascript'>
		$(function(){
			
			$(".color-box img").mousedown(function(){
				return false;
			});
    		$(".photos-crud").sortable({
        		handle: '.move-box',
        		opacity: 0.6,
        		cursor: 'move',
        		revert: true,
        		update: function() {
    				var order = $(this).sortable("serialize");
	    				$.post("http://127.0.0.1/polaris/admin/diapositivas/ordering", order, function(theResponse){});
    			}
    		});
    		$('.ic-title-field').keyup(function(e) {
    			if(e.keyCode == 13) {
					var data_id = $(this).attr('data-id');
					var data_title = $(this).val();

					saveTitle(data_id, data_title);
    			}
    		});

    		$('.ic-title-field').bind({
    			  click: function() {
    				$(this).css('resize','both');
    			    $(this).css('overflow','auto');
    			    $(this).animate({height:80},600);
    			  },
    			  blur: function() {
      			    $(this).css('resize','none');
      			  	$(this).css('overflow','hidden');
      			  	$(this).animate({height:20},600);

					var data_id = $(this).attr('data-id');
					var data_title = $(this).val();

					saveTitle(data_id, data_title);
    			  }
    		});
		});
	</script>
	<ul class='photos-crud'>
	<li id="photos_1">
	<div class='photo-box'>
	<a href='http://127.0.0.1/polaris/assets/img/web/slideshow/18b62-1.jpg' title="" target='_blank' class="color-box" rel="color-box" tabindex="-1"><img src='http://127.0.0.1/polaris/assets/img/web/slideshow/thumb__18b62-1.jpg' width='90' height='60' class='basic-image' /></a>
	<textarea class="ic-title-field" data-id="1" autocomplete="off" ></textarea>
	<div class="clear"></div>					<div class="move-box"></div>					<div class='delete-box'>
	<a href='http://127.0.0.1/polaris/admin/diapositivas/delete_file/1' class='delete-anchor' tabindex="-1">Borrar</a>
	</div>					<div class="clear"></div>
	</div>
	</li>
				<li id="photos_6">
				<div class='photo-box'>
					<a href='http://127.0.0.1/polaris/assets/img/web/slideshow/0def4-6.jpg' title="" target='_blank' class="color-box" rel="color-box" tabindex="-1"><img src='http://127.0.0.1/polaris/assets/img/web/slideshow/thumb__0def4-6.jpg' width='90' height='60' class='basic-image' /></a>
										<textarea class="ic-title-field" data-id="6" autocomplete="off" ></textarea>
					<div class="clear"></div>					<div class="move-box"></div>					<div class='delete-box'>
						<a href='http://127.0.0.1/polaris/admin/diapositivas/delete_file/6' class='delete-anchor' tabindex="-1">Borrar</a>
					</div>					<div class="clear"></div>
				</div>
			</li>
				<li id="photos_2">
				<div class='photo-box'>
					<a href='http://127.0.0.1/polaris/assets/img/web/slideshow/aae41-2.jpg' title="" target='_blank' class="color-box" rel="color-box" tabindex="-1"><img src='http://127.0.0.1/polaris/assets/img/web/slideshow/thumb__aae41-2.jpg' width='90' height='60' class='basic-image' /></a>
										<textarea class="ic-title-field" data-id="2" autocomplete="off" ></textarea>
					<div class="clear"></div>					<div class="move-box"></div>					<div class='delete-box'>
						<a href='http://127.0.0.1/polaris/admin/diapositivas/delete_file/2' class='delete-anchor' tabindex="-1">Borrar</a>
					</div>					<div class="clear"></div>
				</div>
			</li>
				
			</ul>
		<div class='clear'></div>
	</div></div>

 <!-- Bootstrap core JavaScript
    ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
   <script src="http://127.0.0.1/polaris/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- SIN NN<script src="http://127.0.0.1/polaris/assets/bootstrap/win/docs.min.js"></script>-->
    


</body>
</html>
