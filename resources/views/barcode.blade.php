<style type="text/css">
	img{
		padding-left: 20px;
	}
</style>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-primary" style="text-align: center;">Laravel 5 Barcode Generator Using milon/barcode</h1>
    </div>
</div>


<div class="container text-center" style="border: 1px solid #a1a1a1;padding: 15px;width: 70%;">
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('44455656', 'EAN2')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('4445656', 'EAN5')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('4445', 'EAN8')}}" alt="barcode" />
	<img src="data:image/png;base64,{{DNS1D::getBarcodePNG('4445', 'EAN13')}}" alt="barcode" />
</div>