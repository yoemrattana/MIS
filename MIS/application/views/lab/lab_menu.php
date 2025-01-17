<style>
	#wrapper { padding: 0 0 50px 120px; }
	.menubox { width:120px; background: #f5f5f5; border-right: 1px solid #ddd; position: fixed; left: 0; top: 0; bottom: 0; z-index: 9; }
	.menu { display: block; padding: 8px; color: #555; border-bottom: 1px solid #ddd; font-size: 14px; }
	.menu:first-of-type { border-top: 1px solid #ddd; }
	.menu:hover, .menu:focus { text-decoration: none; background: white; color: black; border-right: 3px solid #FF6400; }
	.menu.active { background: #ffe7d8; color: black; border-right: 3px solid #FF6400; }
	.menubox span { font-size: 100px; display: inline; }
	.panel-heading { padding: 5px 10px; background: white !important; }
	.btn-home, .btn-home:hover, .btn-home:focus { color: #FF6400; border-color: #FF6400; }
	.btn-home:hover { background: #ffe7d8; }

	.menu2 { display: inline-block; padding-top: 4px; margin: 0 6px; border-bottom: 3px solid transparent; }
	.menu2, .menu2:hover { color: #FF6400; text-decoration: none; }
	.menu2.active { font-weight: bold; }
	.menu2.active, .menu2:hover { border-bottom-color: #FF6400; }

	@media print {
		#wrapper { padding: 0; }
		.panel { border: none; }
	}
</style>

<div class="menubox hidden-print" data-bind="visible: true" style="display:none">
	<div class="text-center">
		<span class="material-icons text-primary">biotech</span>
	</div>
	<a href="/Lab/index/staff" class="menu">Staff Profile</a>
	<a href="/Lab/index/logbook" class="menu">Log Book</a>
	<a href="/Lab/index/crosscheck" class="menu">Cross-Checking</a>
	<a href="/Lab/index/referenceslide" class="menu">Reference Slide</a>
	<a href="/Lab/index/paneltesting" class="menu">Panel Testing</a>
	<a href="/Lab/index/eqa" class="menu">EQA</a>
	<a href="/Lab/index/equipment" class="menu">Equipment</a>
	<a href="/Lab/index/iqa" class="menu">IQA</a>
	<a href="/Lab/index/stock" class="menu">Stock</a>
	<a href="/Lab/index/ncamm_training" class="menu">NCAMM</a>
	<a href="/Lab/index/ecamm_training" class="menu">ECAMM</a>
	<a href="/Lab/index/preecamm_training" class="menu">Pre-ECAMM</a>
	<a href="/Lab/index/basic_training" class="menu">Basic</a>
	<a href="/Lab/index/refresher_training" class="menu">Refresher</a>
	<a href="/Lab/index/slidebank" class="menu">Slide Bank</a>
	<a href="/Lab/index/dashboard" class="menu">Dashboard</a>
</div>