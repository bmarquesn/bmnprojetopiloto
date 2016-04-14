<style type="text/css">
@media (max-width: 1024px) {
    .navbar-header {
        float: none;
    }
    .navbar-toggle {
        display: block;
    }
    .navbar-collapse {
        border-top: 1px solid transparent;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    }
	.navbar-collapse.in {
		overflow-y: auto;
	}
    .navbar-collapse.collapse {
        display: none!important;
    }
    .navbar-nav {
        float: none!important;
        margin: 7.5px -15px;
    }
    .navbar-nav>li {
        float: none;
    }
    .navbar-nav>li>a {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .navbar-text {
        float: none;
        margin: 15px 0;
    }
    /* since 3.1.0 */
    .navbar-collapse.collapse.in { 
        display: block!important;
    }
    .collapsing {
        overflow: hidden!important;
    }

</style>
<nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="container">
		<div class="navbar-header">
			<?php if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) { ?>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php } ?>
			<a class="navbar-brand" href="<?php echo base_url().'sistema'; ?>">BMN</a>
		</div>
		<?php if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])) { ?>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="nav navbar-nav">
				<li<?php if(isset($prospects)){echo ' class="active"';}?>><a href="<?php echo base_url().'prospects'; ?>">Prospects</a></li>
				<li<?php if(isset($usuarios)){echo ' class="active"';}?>><a href="<?php echo base_url().'usuarios'; ?>">Usuários</a></li>
			</ul>
			<div style="position:relative;left:10px;"><a href="<?php echo base_url().'sistema/sair'; ?>" class="btn btn-danger" onclick="return confirm('Deseja mesmo sair do sistema?')">Sair</a></div>
		</div>
		<?php } ?>
	</div>
</nav>