<div class="fixed-sidebar left" style="top: 0">
	<div class="fixed-sidebar-left sidebar--small" id="sidebar-left">

		<a href="#" class="logo js-sidebar-open">
			<div class="img-wrap">
				<img loading="lazy" src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/public/images/logo.png'; ?>" alt="Minppal" width="80" height="80">
			</div>
		</a>

		<div class="mCustomScrollbar" data-mcs-theme="dark">
			
		</div>
	</div>

	<div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
		<a href="#" class="logo js-sidebar-open">
			<div class="img-wrap">
                <img loading="lazy" src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/public/images/logo.png'; ?>" alt="Minppal" width="60" height="60">
			</div>
			<div class="title-block">
				<h6 class="logo-title">MINPPAL</h6>
			</div>
		</a>

		<div class="mCustomScrollbar" data-mcs-theme="dark">
			
		</div>
	</div>
</div>

<!-- ... end Fixed Sidebar Left -->


<!-- Fixed Sidebar Left -->

<div class="fixed-sidebar left fixed-sidebar-responsive" style="top: 0">

	<div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
		<a href="#" class="logo js-sidebar-open">
			<img loading="lazy" src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/public/images/logo.png'; ?>" alt="Minppal" width="80" height="80">    
		</a>

	</div>

	<div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
		<a href="#" class="logo js-sidebar-open">
			<div class="img-wrap">
                <img loading="lazy" src="<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/public/images/logo.png'; ?>" alt="Minppal" width="34" height="34">
			</div>
			<div class="title-block">
				<h6 class="logo-title">MINPPAL</h6>
			</div>
		</a>

		<div class="mCustomScrollbar" data-mcs-theme="dark">

			<div class="control-block">
				<div class="author-page author vcard inline-items">
					<div class="author-thumb">
                        <i class="fas fa-user" style="font-size: 36px;"></i>
                        <span class="icon-status online"></span>
					</div>
					<a href="#" class="author-name fn">
						<div class="author-title">
                            <?php echo $_SESSION['user']; ?>
						</div>
						<span class="author-subtitle">
                            <?php echo $_SESSION['role'] === 'admin' ? 'Administrador' : 'Lector'; ?>
                        </span>
					</a>
				</div>
			</div>

            <hr>

			<ul class="account-settings">
                <li>
					<a href="#" class="js-sidebar-open">
						<svg class="olymp-close-icon left-menu-icon"><use xlink:href="#olymp-close-icon"></use></svg>
						<span class="left-menu-title">Cerrar Menú</span>
					</a>
				</li>
				
				<li>
					<a href="/auth/logout">
						<svg class="olymp-logout-icon"><use xlink:href="#olymp-logout-icon"></use></svg>

						<span>Cerrar Sesión</span>
					</a>
				</li>
			</ul>

		</div>
	</div>
</div>