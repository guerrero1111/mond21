<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>
<style>
	.row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
}
.vcenter{
  display:flex;
  flex-direction:column;
  justify-content:center;
  }
.vbottom{
  display:flex;
  flex-direction:column;
  justify-content:flex-end;
}
.containersinb{
	padding: 40px;
}
.conten{
	margin-bottom: 50px;
}
</style>

 <!-- contenido-->
<div class="container mecanica">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="<?php echo base_url()?>img/comoganar.png" style="margin: 25px auto 0px;" class="img-responsive sinizquierdo">
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mecanicaconte">
		
		<div class="col-md-push-2 col-md-8 conten" style="margin: 30px auto;">
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mecani1a">
				<img src="<?php echo base_url()?>img/mecanica1.png" style="margin: 10px auto;width:100%;" class=" sinizquierdo">
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mecani1a">
				<img src="<?php echo base_url()?>img/mecanica2.png" style="margin: 10px auto;width:100%;" class=" sinizquierdo">
			</div>
			
		</div>
		
		
	</div>	
	
</div>



<?php $this->load->view( 'footer' ); ?>