<?php

?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=abtf_css_update'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">
						<h3 class="hndle">
							<span><?php _e( 'CSS Optimization', 'abovethefold' ); ?></span>
						</h3>
						<div class="inside testcontent">

<?php

	/**
	 * Get version of local loadCSS
	 */
	$loadcss_version = '';
	$loadcss_package = WPABTF_PATH . 'public/js/src/loadcss_package.json';
	if (!file_exists($loadcss_package)) {
?>
	<h1 style="color:red;">WARNING: PLUGIN INSTALLATION NOT COMPLETE, MISSING public/js/src/loadcss_package.json</h1>
<?php
	} else {

		$package = @json_decode(file_get_contents($loadcss_package),true);
		if (!is_array($package)) {
?>
	<h1 style="color:red;">failed to parse public/js/src/loadcss_package.json</h1>
<?php
		} else { 

			// set version
			$loadcss_version = $package['version'];
		}
	}

	if (empty($loadcss_version)) {
		$loadcss_version = '(unknown)';
	}

?>
						<table class="form-table">
							<tr valign="top">
								<th scope="row">Optimize CSS Delivery</th>
								<td>
									<label><input type="checkbox" name="abovethefold[cssdelivery]" value="1"<?php if (!isset($options['cssdelivery']) || intval($options['cssdelivery']) === 1) { print ' checked'; } ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.cssdeliveryoptions').show(); } else { jQuery('.cssdeliveryoptions').hide(); }"> Enabled</label>
									<p class="description">When enabled, CSS files are loaded asynchronously via <a href="https://github.com/filamentgroup/loadCSS" target="_blank">loadCSS</a> (v<?php print $loadcss_version;?>).  <a href="https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery?hl=<?php print $lgcode;?>" target="_blank">Click here</a> for the recommendations by Google.</p>
								</td>
							</tr>
							<tr valign="top" class="cssdeliveryoptions" style="<?php if (isset($options['cssdelivery']) && intval($options['cssdelivery']) !== 1) { print 'display:none;'; } ?>">
								<td colspan="2" style="padding-top:0px;">

									<div class="abtf-inner-table">

										<h3 class="h"><span>CSS Delivery Optimization</span></h3>
										<div class="inside">
											<table class="form-table">
												<tr valign="top">
													<th scope="row">Enhanced loadCSS</th>
													<td>
														<label><input type="checkbox" name="abovethefold[loadcss_enhanced]" value="1" onchange="if (jQuery(this).is(':checked')) { jQuery('.enhancedloadcssoptions').show(); } else { jQuery('.enhancedloadcssoptions').hide(); }"<?php if (!isset($options['loadcss_enhanced']) || intval($options['loadcss_enhanced']) === 1) { print ' checked'; } ?>> Enabled</label>
														<p class="description">When enabled, a customized version of loadCSS is used to make use of the <code>requestAnimationFrame</code> API following the <a href="https://developers.google.com/speed/docs/insights/OptimizeCSSDelivery?hl=<?php print $lgcode;?>" target="_blank">recommendations by Google</a>.</p>
													</td>
												</tr>
												<tr valign="top" class="enhancedloadcssoptions" style="<?php if (isset($options['loadcss_enhanced']) && intval($options['loadcss_enhanced']) !== 1) { print 'display:none;'; } ?>">
													<th scope="row">CSS render delay</th>
													<td>
														<table cellpadding="0" cellspacing="0" border="0">
															<tr>
																<td valign="top" style="padding:0px;vertical-align:top;"><input type="number" min="0" max="3000" step="1" name="abovethefold[cssdelivery_renderdelay]" size="10" value="<?php print ((empty($options['cssdelivery_renderdelay']) || $options['cssdelivery_renderdelay'] === 0) ? '' : htmlentities($options['cssdelivery_renderdelay'],ENT_COMPAT,'utf-8')); ?>" onkeyup="if (jQuery(this).val() !== '' && jQuery(this).val() !== '0') { jQuery('#warnrenderdelay').show(); } else { jQuery('#warnrenderdelay').hide(); }" onchange="if (jQuery(this).val() === '0') { jQuery(this).val(''); } if (jQuery(this).val() !== '' && jQuery(this).val() !== '0') { jQuery('#warnrenderdelay').show(); } else { jQuery('#warnrenderdelay').hide(); }" placeholder="0 ms" /></td>
																<td valign="top" style="padding:0px;vertical-align:top;padding-left:10px;font-size:11px;"><div id="warnrenderdelay" style="padding:0px;margin:0px;<?php print ((empty($options['cssdelivery_renderdelay']) || $options['cssdelivery_renderdelay'] === 0 || trim($options['cssdelivery_renderdelay']) === '') ? 'display:none;' : ''); ?>"><span style="color:red;font-weight:bold;">Warning:</span> A higher Google PageSpeed score may sometimes be achieved using this option but it may not be beneficial to the page rendering experience of your users. Often it is best to seek an alternative solution.</div></td>
															</tr>
														</table>
														<p class="description" style="clear:both;">Optionally, enter a time in milliseconds to delay the rendering of CSS files.</p>

													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Position</th>
													<td>
														<select name="abovethefold[cssdelivery_position]">
															<option value="header"<?php if (isset($options['cssdelivery_position']) && $options['cssdelivery_position'] === 'header') { print ' selected'; } ?>>Header</option>
															<option value="footer"<?php if (!isset($options['cssdelivery_position']) || empty($options['cssdelivery_position']) || $options['cssdelivery_position'] === 'footer') { print ' selected'; } ?>>Footer</option>
														</select>
														<p class="description">Select the position where the async loading of CSS will start.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Ignore List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[cssdelivery_ignore]"><?php if (isset($options['cssdelivery_ignore'])) { echo htmlentities($options['cssdelivery_ignore'],ENT_COMPAT,'utf-8'); } ?></textarea>
														<p class="description">Stylesheets to ignore in CSS delivery optimization. One stylesheet per line. The files will be left untouched in the HTML.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Remove List</th>
													<td>
														<textarea style="width: 100%;height:50px;font-size:11px;" name="abovethefold[cssdelivery_remove]"><?php if (isset($options['cssdelivery_remove'])) { echo htmlentities($options['cssdelivery_remove'],ENT_COMPAT,'utf-8'); } ?></textarea>
														<p class="description">Stylesheets to remove from HTML. One stylesheet per line. This feature enables to include small plugin related CSS files inline.</p>
													</td>
												</tr>
											</table>
										</div>

									</div>

								</td>
							</tr>
<?php

	/**
	 * Get version of local webfont.js
	 */
	$webfont_version = $this->CTRL->gwfo->package_version(true);
	if (empty($webfont_version)) {
		$webfont_version = '(unknown)';
	}

?>
							<tr valign="top">
								<th scope="row">Optimize Web Fonts</th>
								<td>
									<label><input type="checkbox" name="abovethefold[gwfo]" value="1"<?php if (!isset($options['gwfo']) || intval($options['gwfo']) === 1) { print ' checked'; } ?> onchange="if (jQuery(this).is(':checked')) { jQuery('.gwfooptions').show(); } else { jQuery('.gwfooptions').hide(); }"> Enabled
									</label>
									<p class="description">When enabled, web fonts are optimized using <a href="https://github.com/typekit/webfontloader" target="_blank">Google Web Font Loader</a>.</p>
								</td>
							</tr>
							<tr valign="top" class="gwfooptions" style="<?php if (isset($options['gwfo']) && intval($options['gwfo']) !== 1) { print 'display:none;'; } ?>">
								<td colspan="2" style="padding-top:0px;">

									<div class="abtf-inner-table">

										<h3 class="h"><span>Web Font Optimization</span></h3>

										<div class="inside">
											<table class="form-table">
												<tr valign="top">
													<th scope="row">webfont.js Load Method</th>
													<td>
														<select name="abovethefold[gwfo_loadmethod]">
															<option value="inline"<?php if (!isset($options['gwfo_loadmethod']) || $options['gwfo_loadmethod'] === 'inline') { print ' selected'; } ?>>Inline</option>
															<option value="async"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'async') { print ' selected'; } ?>>Async</option>
															<option value="async_cdn"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'async_cdn') { print ' selected'; } ?>>Async from Google CDN (v<?php print $this->CTRL->gwfo->cdn_version; ?>)</option>
															<option value="wordpress"<?php if (isset($options['gwfo_loadmethod']) && $options['gwfo_loadmethod'] === 'wordpress') { print ' selected'; } ?>>WordPress include</option>
														</select>
														<p class="description">Select the method to load <a href="https://developers.google.com/speed/libraries/?hl=<?php print $lgcode;?>#web-font-loader" target="_blank">webfont.js</a> (v<?php print $webfont_version; ?>).</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Load Position</th>
													<td>
														<select name="abovethefold[gwfo_loadposition]">
															<option value="header"<?php if (!isset($options['gwfo_loadposition']) || $options['gwfo_loadposition'] === 'header') { print ' selected'; } ?>>Header</option>
															<option value="footer"<?php if (isset($options['gwfo_loadposition']) && $options['gwfo_loadposition'] === 'footer') { print ' selected'; } ?>>Footer</option>
														</select>
														<p class="description">Select the position where the loading of web fonts will start.</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">WebFontConfig</th>
													<td>
														<textarea style="width: 100%;height:100px;font-size:11px;" name="abovethefold[gwfo_config]" placeholder="WebFontConfig = { classes: false, typekit: { id: 'xxxxxx' }, loading: function() {}, google: { families: ['Droid Sans', 'Droid Serif'] } };"><?php if (isset($options['gwfo_config'])) { echo htmlentities($options['gwfo_config']); } ?></textarea>
														<p class="description">Enter the <code>WebFontConfig</code> variable for Google Web Font Loader. Leave blank for the default configuration. (<a href="https://github.com/typekit/webfontloader#configuration" target="_blank">more information</a>)</p>
													</td>
												</tr>
												<tr valign="top">
													<th scope="row">Google Web Fonts</th>
													<td>
														<textarea style="width: 100%;height:<?php if (count(explode("\n",$options['gwfo_googlefonts'])) > 3) { print '100px'; } else { print '50px'; } ?>;font-size:11px;" name="abovethefold[gwfo_googlefonts]" placeholder="Droid Sans
							Open Sans Condensed:300,700:latin,greek"><?php if (isset($options['gwfo_googlefonts'])) { echo htmlentities($options['gwfo_googlefonts']); } ?></textarea>
														<p class="description">Enter the <a href="https://developers.google.com/fonts/docs/getting_started?hl=<?php print $lgcode;?>&csw=1" target="_blank">Google Font API</a> definitions of <a href="https://fonts.google.com/?hl=<?php print $lgcode;?>" target="_blank">Google Web Fonts</a> to load. One font per line. (<a href="https://github.com/typekit/webfontloader#google" target="_blank">documentation</a>)</p>
													</td>
												</tr>
											</table>
										</div>
									</div>

								</td>
							</tr>
						</table>
						<hr />
						<?php
							submit_button( __( 'Save' ), 'primary large', 'is_submit', false );
						?>

						</div>
					</div>


	<!-- End of #post_form -->

				</div>
			</div> <!-- End of #post-body -->
		</div> <!-- End of #poststuff -->
	</div> <!-- End of .wrap .nginx-wrapper -->
</form>