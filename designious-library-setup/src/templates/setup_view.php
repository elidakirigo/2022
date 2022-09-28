<?php
$hasWoo    = class_exists( 'woocommerce' ) && ! empty( $GLOBALS['woocommerce'] );
$hasLumise = class_exists( 'lumise' ) && ! empty( $GLOBALS['lumise'] ) && ! empty( $GLOBALS['lumise_woo'] );

/** @var DesigniousLibrarySetup $designious_library_setup */
global $designious_library_setup;
$latestVersion    = $designious_library_setup->get_latest_addon_version();
$installedVersion = $designious_library_setup->get_addon_version();
$hasUpgrade       = ( ! $installedVersion || ( $installedVersion && $installedVersion !== $latestVersion['tag'] ) );
$canInstall       = ( ! $designious_library_setup->is_addon_installed() || $hasUpgrade )
                    && $hasWoo
                    && $hasLumise
                    && ! empty( $latestVersion )
                    && ! $designious_library_setup->isInstallAttempt();
?>
<div class="wrap designious">
    <h1 class="wp-heading-inline">Designious Library Setup</h1>
    <div class="requirements-wrapper">
        <h2>Requirements</h2>
        <div class="requirements-outcome">
            <div class="outcome-<?php echo $hasWoo ? 'success' : 'fail'; ?>">
                <span class="dashicons dashicons-<?php echo $hasWoo ? 'yes' : 'no'; ?>"></span>
                WooCommerce
            </div>
            <div class="outcome-<?php echo $hasLumise ? 'success' : 'fail'; ?>">
                <span class="dashicons dashicons-<?php echo $hasLumise ? 'yes' : 'no'; ?>"></span>
                Lumise
            </div>
        </div>
        <div class="requirements-message">
			<?php if ( ! $hasWoo || ! $hasLumise ) : ?>
                <p>Cannot install.</p>
			<?php else: ?>
                <p>All requirements met.</p>
			<?php endif; ?>
        </div>
    </div>
	<?php if ( $designious_library_setup->isInstallAttempt() ): ?>
        <p>
			<?php if ( ! $designious_library_setup->hasInstallError() ): ?>
                <strong>Latest addon version installed: <?php echo $designious_library_setup->get_addon_version(); ?></strong>
                <br/>
                <strong>Please go to Lumise > Addons to activate it.</strong>
			<?php else: ?>
                <strong>There was an error installing the addon.</strong>
			<?php endif; ?>
        </p>
	<?php endif; ?>
	<?php if ( $canInstall ) : ?>
        <form action="" method="post">
            <input type="hidden" name="designious-library-setup" value="true"/>
            <?php echo wp_nonce_field('designious-library-setup') ?>
            <button type="submit" class="button button-primary">
                Install Designious Library Addon <?php echo $latestVersion['tag']; ?> for Lumise
            </button>
        </form>
	<?php elseif ( $hasWoo && $hasLumise && ! empty( $installedVersion && ! $designious_library_setup->isInstallAttempt() ) ): ?>
        <p><strong>Latest addon version already
                installed: <?php echo $designious_library_setup->get_addon_version(); ?></strong></p>
	<?php endif; ?>
</div>