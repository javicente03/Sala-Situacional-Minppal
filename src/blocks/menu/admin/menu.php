<!-- Header-BP -->

<header class="header" id="site-header">

	<div class="page-title">
		<h6>MINPPAL</h6>
	</div>

	<div class="header-content-wrapper">
		<form class="search-bar w-search notification-list friend-requests">
			<div class="form-group with-button">
				<input class="form-control js-user-search" placeholder="Search here people or pages..." type="text">
				<button>
					<svg class="olymp-magnifying-glass-icon"><use xlink:href="#olymp-magnifying-glass-icon"></use></svg>
				</button>
			</div>
		</form>

		<div class="control-block">

			<div class="author-page author vcard inline-items more">
				<div class="author-thumb">
					<!-- <img alt="author" src="img/author-page.webp" width="36" height="36" class="avatar"> -->
                    <!-- icono de font awesome user -->
                    <i class="fas fa-user" style="font-size: 36px;"></i>
					<span class="icon-status online"></span>
					<div class="more-dropdown more-with-triangle">
						<div class="mCustomScrollbar" data-mcs-theme="dark">
							<div class="ui-block-title ui-block-title-small">
								<h6 class="title">MINPPAL</h6>
							</div>

							<ul class="account-settings">
								
								<li>
									<a href="/auth/logout">
										<svg class="olymp-logout-icon"><use xlink:href="#olymp-logout-icon"></use></svg>

										<span>Log Out</span>
									</a>
								</li>
							</ul>

						</div>

					</div>
				</div>
				<a class="author-name fn" style="cursor: pointer;">
					<div class="author-title">
                        <?php echo $_SESSION['user']; ?>
                        <svg class="olymp-dropdown-arrow-icon"><use xlink:href="#olymp-dropdown-arrow-icon"></use></svg>
					</div>
					<span class="author-subtitle">
                        <?php echo $_SESSION['role'] === 'admin' ? 'Administrador' : 'Lector'; ?>
                    </span>
				</a>
			</div>

		</div>
	</div>

</header>

<!-- ... end Header-BP -->