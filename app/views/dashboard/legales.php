<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view( 'header' ); ?>
<?php $this->load->view( 'navbar' ); ?>

<style type="text/css">
	/*body {
    background-image: url('<?php echo base_url().$this->session->userdata('c8'); ?>') !important;
    background-repeat: no-repeat;
    background-size: 100% auto;
    background-position: center top;
	}
	@media screen and (max-width: 480px) {
		body {	   
	    background-size: 200% auto;
		}
	}*/
	*{
		
		text-transform: capitalize !important;
	}
	.transparencia,.transparencia p,.transparencia a,.transparencia li{
		font-family: Sofia !important;
		line-height: 1px !important;
		font-size: 16px !important;
		color: #ffffff !important;
	}
	.login_out ul{
		list-style: none !important;
	}
	.login_out ul a,.login_out ul span{
		text-transform: uppercase !important;
	}
	table,tr,td{
		border:1px solid #1b2668 !important;
		text-align: center;
	}
	img{
		max-width: 100%;
	}
	ul{
		margin-top: 0pt;
    margin-left: 18pt;
    margin-bottom: 0pt;
    text-align: justify;
    font-size: 11pt;
        color: #ffffff !important;
       list-style: initial !important;
        line-height: initial !important;
	}
	ol{
			margin-top: 0pt;
    margin-left: 18pt;
    margin-bottom: 0pt;
    text-align: justify;
    font-size: 11pt;
       color: #ffffff !important;
		 list-style: none !important;
		 line-height: initial !important;
	}
	ol li{
		font-family: Sofia !important;
		 
		    margin: 22px 0px !important;
	}
	h2,a{
		color: #ffffff !important;
	}
	.legalesa li,.legalesa p{
		line-height: 1.3 !important;
		font-size: 18px;
	}
</style>

 <!-- aviso-->

<div class="container aviso">
	<div class="row">
		
		<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 transparencia legalesa">
      
		<h1 style="text-align: center;"><strong></strong><strong></strong></h1>


<h2 style="text-align: center;"><u>BASES, T&Eacute;RMINOS Y CONDICIONES</u></h2>



		</div>
	</div>
</div>



<?php $this->load->view( 'footer' ); ?>
