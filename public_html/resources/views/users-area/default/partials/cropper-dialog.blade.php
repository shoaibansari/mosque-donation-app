{{--
Required Parameters:
$post_url = '';
$heading = '';
$image = '';
--}}
<!-- Modal -->
<div class="modal fade " id="cropper-modal" aria-labelledby="modalLabel" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close avatar-modal-close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="avatar-modal-label">{{ $heading or 'Edit Image' }}</h4>

			</div>
			  <ul class="nav nav-tabs" style="margin-top: 10px;">
			    <li class="active"  style="margin-left: 10px;"><a data-toggle="tab" href="#home">Tall</a></li>
			    <li><a data-toggle="tab" href="#menu1">Wide</a></li>
			    <li><a data-toggle="tab" href="#menu2">Small</a></li>
				<li class="pull-right" style="margin-right: 10px;"> <button class="btn btn-primary saveallthree">Save</button></li>
			  </ul>

			  <div class="tab-content">
			    <div id="home" class="tab-pane fade in active">
			      	<div class="modal-body">
						<div class="row">
							
							<div class="col-md-9">
								<div class="img-container">
									<img class="image" id="image" src="" alt="">
								</div>
							</div>
							
							<div class="col-md-3">
								
								<div class="docs-preview clearfix">
									<div class="prv1 img-preview preview-lg"></div>
								</div>
								
								<!-- <div>
									<button class="btn btn-primary">Done</button>
								</div> -->
							</div>
						</div>
						<div class="row">					
							<div class="col-md-9 docs-buttons">						
								<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
									<input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
									<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image">
										<span class="fa fa-upload"></span> Browse...
								    </span>
								</label>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-plus"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-minus"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									
									<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-right"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-up"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-down"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-right"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-h"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-v"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="reset" title="Reset">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-refresh"></span>
								            </span>
									</button>							
								</div>
								
								
							<!-- Show the cropped image in modal -->
								<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body"></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
												</button>
												<a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
											</div>
										</div>
									</div>
								</div><!-- /.modal -->
								
								
							</div><!-- /.docs-buttons -->
						</div>
					</div>
			    </div>
			    <div id="menu1" class="tab-pane fade">
			      	<div class="modal-body">
						<div class="row">
							
							<div class="col-md-9">
								<div class="img-container">
									<img class="image" id="image" src="" alt="">
								</div>
							</div>
							
							<div class="col-md-3">
								
								<div class="docs-preview clearfix">
									<div class="prv2 img-preview preview-lg"></div>
								</div>
								
								<!-- <div>
									<button class="btn btn-primary">Done</button>
								</div> -->
							</div>
						</div>
						<div class="row">					
							<div class="col-md-9 docs-buttons">						
								<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
									<input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
									<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image">
										<span class="fa fa-upload"></span> Browse...
								    </span>
								</label>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-plus"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-minus"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									
									<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-right"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-up"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-down"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-right"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-h"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-v"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="reset" title="Reset">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-refresh"></span>
								            </span>
									</button>							
								</div>
								
								
							<!-- Show the cropped image in modal -->
								<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body"></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
												</button>
												<a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
											</div>
										</div>
									</div>
								</div><!-- /.modal -->
								
								
							</div><!-- /.docs-buttons -->
						</div>
					</div>
			    </div>
			    <div id="menu2" class="tab-pane fade">
			      	<div class="modal-body">
						<div class="row">
							
							<div class="col-md-9">
								<div class="img-container">
									<img class="image" id="image" src="" alt="">
								</div>
							</div>
							
							<div class="col-md-3">
								
								<div class="docs-preview clearfix">
									<div class="prv3 img-preview preview-lg"></div>
								</div>
								
								<!-- <div>
									<button class="btn btn-primary">Done</button>
								</div> -->
							</div>
						</div>
						<div class="row">					
							<div class="col-md-9 docs-buttons">						
								<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
									<input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
									<span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image">
										<span class="fa fa-upload"></span> Browse...
								    </span>
								</label>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-plus"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-search-minus"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									
									<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-right"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-up"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrow-down"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-left"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-rotate-right"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-h"></span>
								            </span>
									</button>
									<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-arrows-v"></span>
								            </span>
									</button>
								</div>
								
								<div class="btn-group">
									<button type="button" class="btn btn-primary" data-method="reset" title="Reset">
								            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false">
								              <span class="fa fa-refresh"></span>
								            </span>
									</button>							
								</div>
								
								
							<!-- Show the cropped image in modal -->
								<div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body"></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
												</button>
												<a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
											</div>
										</div>
									</div>
								</div><!-- /.modal -->
								
								
							</div><!-- /.docs-buttons -->
						</div>
					</div>
			    </div>
			  </div>
		</div>
	</div>
</div>

<style type="text/css">
	.tab-content > div:not(.active) {
		height: 0px !important;
		overflow: hidden;
	}
</style>
